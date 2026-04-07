<?php

namespace App\Services\ProductImport;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Price;
use App\Models\Product;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProductImportService
{
    public function mappableFields(): array
    {
        return [
            'title' => 'نام محصول (ضروری)',
            'slug' => 'اسلاگ',
            'short_description' => 'توضیح کوتاه',
            'description' => 'توضیحات کامل',
            'price' => 'قیمت (ضروری)',
            'discount_price' => 'قیمت فروش/تخفیف',
            'sku' => 'SKU/کد (اختیاری، برای گزارش)',
            'stock' => 'موجودی',
            'category' => 'دسته‌بندی',
            'subcategory' => 'زیردسته',
            'brand' => 'برند',
            'images' => 'تصاویر (URL، با کاما جدا شود)',
            'published' => 'وضعیت انتشار',
        ];
    }

    public function duplicateStrategies(): array
    {
        return [
            'skip' => 'رد کردن موارد تکراری',
            'update' => 'به‌روزرسانی موارد تکراری',
            'new_only' => 'فقط ایجاد موارد جدید',
        ];
    }

    public function buildPreviewState(UploadedFile $file, string $importToken, array $options): array
    {
        $extension = $file->getClientOriginalExtension();
        $relativePath = 'tmp/product-imports/' . $importToken . '.' . $extension;
        Storage::put($relativePath, file_get_contents($file->getRealPath()));

        $rows = Excel::toArray(null, Storage::path($relativePath));
        $sheetRows = $rows[0] ?? [];

        $headers = array_values(array_filter(array_map(fn($h) => trim((string) $h), Arr::first($sheetRows, []))));
        $samples = collect(array_slice($sheetRows, 1, 5))
            ->map(function ($row) use ($headers) {
                $mapped = [];
                foreach ($headers as $index => $header) {
                    $mapped[$header] = $row[$index] ?? null;
                }

                return $mapped;
            })
            ->values()
            ->all();

        return [
            'headers' => $headers,
            'sampleRows' => $samples,
            'mapping' => $this->guessMapping($headers),
            'importToken' => $importToken,
            'options' => [
                'duplicate_strategy' => $options['duplicate_strategy'],
                'create_missing_taxonomy' => (int) ($options['create_missing_taxonomy'] ?? 0),
                'import_images' => (int) ($options['import_images'] ?? 0),
            ],
        ];
    }

    public function runImport(array $payload): array
    {
        $relativePath = collect(Storage::files('tmp/product-imports'))
            ->first(fn($file) => Str::contains($file, $payload['import_token'] . '.'));

        abort_unless($relativePath && Storage::exists($relativePath), 422, 'فایل انتخاب شده برای ایمپورت پیدا نشد. لطفا دوباره پیش‌نمایش بگیرید.');

        $rows = Excel::toArray(null, Storage::path($relativePath));
        $sheetRows = $rows[0] ?? [];
        $headers = Arr::first($sheetRows, []);

        $result = [
            'total' => max(0, count($sheetRows) - 1),
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'failed' => 0,
            'errors' => [],
            'headers' => array_values(array_filter(array_map(fn($h) => trim((string) $h), $headers))),
            'sample_rows' => [],
        ];

        foreach (array_slice($sheetRows, 1) as $idx => $row) {
            $rowNumber = $idx + 2;

            try {
                DB::transaction(function () use ($row, $headers, $payload, &$result, $rowNumber) {
                    $record = $this->rowToMappedRecord($headers, $row, $payload['mapping']);
                    $this->validateMappedRow($record, $rowNumber);

                    $duplicate = $this->findDuplicateProduct($record);
                    if ($duplicate && in_array($payload['duplicate_strategy'], ['skip', 'new_only'])) {
                        $result['skipped']++;
                        return;
                    }

                    $product = $duplicate ?: new Product();
                    $isNew = !$product->exists;

                    $this->upsertProduct($product, $record, $payload);

                    if ($isNew) {
                        $result['created']++;
                    } else {
                        $result['updated']++;
                    }
                });
            } catch (\Throwable $e) {
                $result['failed']++;
                $result['errors'][] = [
                    'row' => $rowNumber,
                    'message' => $e->getMessage(),
                ];
                Log::warning('Product import row failed', [
                    'row' => $rowNumber,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $result['sample_rows'] = collect(array_slice($sheetRows, 1, 5))
            ->map(function ($row) use ($headers) {
                $mapped = [];
                foreach ($headers as $index => $header) {
                    $mapped[trim((string) $header)] = $row[$index] ?? null;
                }
                return $mapped;
            })
            ->values()
            ->all();

        return $result;
    }

    private function guessMapping(array $headers): array
    {
        $synonyms = [
            'title' => ['title', 'name', 'product name', 'نام', 'نام محصول'],
            'slug' => ['slug', 'url', 'link'],
            'short_description' => ['short_description', 'short description', 'summary'],
            'description' => ['description', 'desc', 'full description', 'توضیحات'],
            'price' => ['price', 'amount', 'قیمت'],
            'discount_price' => ['sale_price', 'discount_price', 'special_price'],
            'sku' => ['sku', 'code', 'product_code'],
            'stock' => ['stock', 'quantity', 'qty', 'inventory', 'موجودی'],
            'category' => ['category', 'cat', 'دسته'],
            'subcategory' => ['subcategory', 'sub_category', 'subcat', 'زیردسته'],
            'brand' => ['brand', 'manufacturer', 'برند'],
            'images' => ['images', 'image', 'image_url', 'image urls'],
            'published' => ['published', 'status', 'visibility'],
        ];

        $mapping = [];
        $normalized = collect($headers)->mapWithKeys(fn($header) => [
            Str::lower(trim($header)) => $header,
        ]);

        foreach ($synonyms as $field => $aliases) {
            $mapping[$field] = '';
            foreach ($aliases as $alias) {
                $matched = $normalized->get(Str::lower($alias));
                if ($matched) {
                    $mapping[$field] = $matched;
                    break;
                }
            }
        }

        return $mapping;
    }

    private function rowToMappedRecord(array $headers, array $row, array $mapping): array
    {
        $indexed = [];
        foreach ($headers as $index => $header) {
            $indexed[trim((string) $header)] = $row[$index] ?? null;
        }

        $record = [];
        foreach (array_keys($this->mappableFields()) as $field) {
            $column = $mapping[$field] ?? null;
            $record[$field] = $column ? ($indexed[$column] ?? null) : null;
        }

        return $record;
    }

    private function validateMappedRow(array $record, int $rowNumber): void
    {
        if (!trim((string) ($record['title'] ?? ''))) {
            throw new \RuntimeException("ردیف {$rowNumber}: نام محصول الزامی است.");
        }

        if (!is_numeric($record['price'])) {
            throw new \RuntimeException("ردیف {$rowNumber}: قیمت معتبر نیست.");
        }

        if ($record['discount_price'] !== null && $record['discount_price'] !== '' && !is_numeric($record['discount_price'])) {
            throw new \RuntimeException("ردیف {$rowNumber}: قیمت تخفیف معتبر نیست.");
        }
    }

    private function findDuplicateProduct(array $record): ?Product
    {
        $slug = trim((string) ($record['slug'] ?? ''));
        if ($slug) {
            $bySlug = Product::where('slug', $slug)->first();
            if ($bySlug) {
                return $bySlug;
            }
        }

        return Product::where('title', trim((string) $record['title']))->first();
    }

    private function upsertProduct(Product $product, array $record, array $payload): void
    {
        $categoryId = $this->resolveCategoryId($record, (int) ($payload['create_missing_taxonomy'] ?? 0));
        $brandId = $this->resolveBrandId($record, (int) ($payload['create_missing_taxonomy'] ?? 0));

        $slug = trim((string) ($record['slug'] ?? ''));
        if (!$slug) {
            $slug = SlugService::createSlug(Product::class, 'slug', $record['title']);
        }

        $product->fill([
            'title' => trim((string) $record['title']),
            'slug' => $slug,
            'type' => 'physical',
            'category_id' => $categoryId,
            'short_description' => $record['short_description'],
            'description' => $record['description'],
            'brand_id' => $brandId,
            'published' => $this->toPublishedValue($record['published']),
            'currency_id' => Currency::query()->value('id'),
            'weight' => $product->weight ?? 0,
            'unit' => $product->unit ?? 'عدد',
            'price_type' => 'multiple-price',
            'rounding_amount' => $product->rounding_amount ?? 'default',
            'rounding_type' => $product->rounding_type ?? 'default',
            'lang' => app()->getLocale(),
            'admin_updated_at' => now(),
        ]);
        $product->save();

        $priceValue = (float) $record['price'];
        $saleValue = $record['discount_price'] !== null && $record['discount_price'] !== '' ? (float) $record['discount_price'] : null;
        $discountPercent = $saleValue !== null && $priceValue > 0 && $saleValue < $priceValue
            ? min(100, max(0, round((($priceValue - $saleValue) / $priceValue) * 100)))
            : 0;

        $price = Price::withTrashed()->firstOrNew([
            'product_id' => $product->id,
            'id' => optional($product->prices()->withTrashed()->first())->id,
        ]);

        $price->fill([
            'price' => $priceValue,
            'discount' => $discountPercent,
            'discount_price' => get_discount_price($priceValue, $discountPercent, $product),
            'regular_price' => get_discount_price($priceValue, 0, $product),
            'stock' => is_numeric($record['stock']) ? (int) $record['stock'] : 0,
            'cart_max' => $price->cart_max,
            'cart_min' => $price->cart_min,
            'deleted_at' => null,
        ]);
        $price->save();

        $product->categories()->sync(array_filter([$categoryId]));

        if ((int) ($payload['import_images'] ?? 0) === 1) {
            $this->importImages($product, (string) ($record['images'] ?? ''));
        }
    }

    private function resolveCategoryId(array $record, int $createMissingTaxonomy): ?int
    {
        $categoryName = trim((string) ($record['category'] ?? ''));
        if (!$categoryName) {
            return null;
        }

        $category = Category::where('type', 'productcat')->where('title', $categoryName)->first();

        if (!$category && $createMissingTaxonomy === 1) {
            $category = Category::create([
                'title' => $categoryName,
                'slug' => $categoryName,
                'type' => 'productcat',
                'published' => true,
                'lang' => app()->getLocale(),
            ]);
        }

        $subcategoryName = trim((string) ($record['subcategory'] ?? ''));

        if ($subcategoryName) {
            $subcategory = Category::where('type', 'productcat')
                ->where('title', $subcategoryName)
                ->when($category, fn($q) => $q->where('category_id', $category->id))
                ->first();

            if (!$subcategory && $createMissingTaxonomy === 1) {
                $subcategory = Category::create([
                    'title' => $subcategoryName,
                    'slug' => $subcategoryName,
                    'type' => 'productcat',
                    'published' => true,
                    'category_id' => optional($category)->id,
                    'lang' => app()->getLocale(),
                ]);
            }

            if ($subcategory) {
                return $subcategory->id;
            }
        }

        return optional($category)->id;
    }

    private function resolveBrandId(array $record, int $createMissingTaxonomy): ?int
    {
        $brandName = trim((string) ($record['brand'] ?? ''));
        if (!$brandName) {
            return null;
        }

        $brand = Brand::where('name', $brandName)->where('lang', app()->getLocale())->first();

        if (!$brand && $createMissingTaxonomy === 1) {
            $brand = Brand::create([
                'name' => $brandName,
                'slug' => $brandName,
                'lang' => app()->getLocale(),
            ]);
        }

        return optional($brand)->id;
    }

    private function toPublishedValue(mixed $value): bool
    {
        $value = Str::lower(trim((string) $value));

        if (in_array($value, ['0', 'false', 'inactive', 'draft', 'no'])) {
            return false;
        }

        return true;
    }

    private function importImages(Product $product, string $images): void
    {
        $urls = collect(explode(',', $images))
            ->map(fn($item) => trim($item))
            ->filter()
            ->values();

        if ($urls->isEmpty()) {
            return;
        }

        foreach ($urls as $index => $url) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                continue;
            }

            try {
                $response = Http::timeout(20)->get($url);
                if (!$response->successful()) {
                    continue;
                }

                $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                $filename = uniqid('import_') . '_' . $product->id . '.' . Str::lower($extension);
                Storage::disk('public')->put('products/' . $filename, $response->body());

                if ($index === 0 && !$product->image) {
                    $product->update(['image' => '/uploads/products/' . $filename]);
                }

                $product->gallery()->firstOrCreate([
                    'image' => '/uploads/products/' . $filename,
                ], [
                    'ordering' => $index + 1,
                ]);
            } catch (\Throwable $e) {
                Log::warning('Product import image failed', [
                    'product_id' => $product->id,
                    'url' => $url,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
