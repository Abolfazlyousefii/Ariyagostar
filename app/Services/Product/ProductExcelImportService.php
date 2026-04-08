<?php

namespace App\Services\Product;

use App\Models\Category;
use App\Models\Product;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class ProductExcelImportService
{
    public function import(UploadedFile $file): array
    {
        $summary = [
            'total_rows' => 0,
            'imported' => 0,
            'updated' => 0,
            'skipped' => 0,
            'failed' => 0,
            'failures' => [],
        ];

        if (strtolower($file->getClientOriginalExtension()) === 'csv') {
            Config::set('excel.imports.csv.delimiter', ',');
            Config::set('excel.imports.csv.input_encoding', 'UTF-8');
        }

        $rows = Excel::toArray(null, $file);
        $sheetRows = $rows[0] ?? [];

        if (empty($sheetRows)) {
            $summary['failures'][] = [
                'row' => 0,
                'reason' => 'فایل خالی است یا قابل خواندن نیست.',
            ];
            $summary['failed'] = 1;

            return $summary;
        }

        $headers = collect($sheetRows[0])
            ->map(fn ($header) => Str::lower(trim((string) $header)))
            ->toArray();

        $headerIndexes = [
            'product_id' => array_search('product_id', $headers, true),
            'product_name' => array_search('product_name', $headers, true),
            'categories' => array_search('categories', $headers, true),
        ];

        foreach ($headerIndexes as $column => $index) {
            if ($index === false) {
                $summary['failures'][] = [
                    'row' => 1,
                    'reason' => "ستون {$column} در فایل پیدا نشد.",
                ];
                $summary['failed'] = 1;

                return $summary;
            }
        }

        foreach ($sheetRows as $rowIndex => $row) {
            if ($rowIndex === 0) {
                continue;
            }

            $summary['total_rows']++;

            $excelRowNumber = $rowIndex + 1;

            $externalId = trim((string) ($row[$headerIndexes['product_id']] ?? ''));
            $productName = trim((string) ($row[$headerIndexes['product_name']] ?? ''));
            $categoriesRaw = trim((string) ($row[$headerIndexes['categories']] ?? ''));

            if ($externalId === '' && $productName === '' && $categoriesRaw === '') {
                $summary['skipped']++;
                continue;
            }

            if ($externalId === '' || $productName === '') {
                $summary['failed']++;
                $summary['failures'][] = [
                    'row' => $excelRowNumber,
                    'reason' => 'product_id و product_name الزامی هستند.',
                ];
                continue;
            }

            try {
                $product = Product::where('external_product_id', $externalId)->first();

                $data = [
                    'title' => $productName,
                    'slug' => $product?->slug ?: SlugService::createSlug(Product::class, 'slug', $productName . '-' . $externalId),
                    'type' => 'physical',
                    'price_type' => 'multiple-price',
                    'external_product_id' => $externalId,
                    'lang' => app()->getLocale(),
                    'published' => false,
                    'admin_updated_at' => now(),
                ];

                if ($product) {
                    $product->update($data);
                    $summary['updated']++;
                } else {
                    $product = Product::create($data);
                    $summary['imported']++;
                }

                $categoryIds = $this->parseAndResolveCategories($categoriesRaw);

                if (!empty($categoryIds)) {
                    $product->categories()->sync($categoryIds);
                    if (!$product->category_id || !in_array($product->category_id, $categoryIds, true)) {
                        $product->category_id = $categoryIds[0];
                        $product->save();
                    }
                }
            } catch (Throwable $exception) {
                $summary['failed']++;
                $summary['failures'][] = [
                    'row' => $excelRowNumber,
                    'reason' => $exception->getMessage(),
                ];
            }
        }

        return $summary;
    }

    private function parseAndResolveCategories(string $categoriesRaw): array
    {
        if ($categoriesRaw === '') {
            return [];
        }

        $names = preg_split('/[,|;]+/', $categoriesRaw) ?: [];
        $names = collect($names)
            ->map(fn ($name) => trim($name))
            ->filter()
            ->unique(fn ($name) => Str::lower($name))
            ->values();

        $categoryIds = [];

        foreach ($names as $name) {
            $existing = Category::detectLang()
                ->where('type', 'productcat')
                ->whereRaw('LOWER(title) = ?', [Str::lower($name)])
                ->first();

            if (!$existing) {
                $existing = Category::create([
                    'title' => $name,
                    'slug' => SlugService::createSlug(Category::class, 'slug', $name),
                    'type' => 'productcat',
                    'published' => true,
                    'lang' => app()->getLocale(),
                ]);
            }

            $categoryIds[] = $existing->id;
        }

        return array_values(array_unique($categoryIds));
    }
}
