<?php

namespace App\Services\ProductImport;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProcessedProductImportService
{
    public function import(string $filePath, string $lang = 'fa'): array
    {
        $rows = Excel::toArray(null, $filePath)[0] ?? [];

        if (count($rows) === 0) {
            return [
                'total_rows' => 0,
                'imported' => 0,
                'updated' => 0,
                'skipped' => 0,
                'failed' => 0,
                'errors' => ['فایل انتخاب‌شده خالی است.'],
            ];
        }

        $headerMap = $this->extractHeaderMap($rows[0]);

        $required = ['product_id', 'product_name', 'categories'];
        foreach ($required as $field) {
            if (!isset($headerMap[$field])) {
                return [
                    'total_rows' => max(count($rows) - 1, 0),
                    'imported' => 0,
                    'updated' => 0,
                    'skipped' => 0,
                    'failed' => 0,
                    'errors' => ["ستون {$field} در فایل وجود ندارد."],
                ];
            }
        }

        $result = [
            'total_rows' => max(count($rows) - 1, 0),
            'imported' => 0,
            'updated' => 0,
            'skipped' => 0,
            'failed' => 0,
            'errors' => [],
        ];

        foreach ($rows as $index => $row) {
            if ($index === 0 || $this->isEmptyRow($row)) {
                continue;
            }

            $rowNumber = $index + 1;
            $productId = trim((string) ($row[$headerMap['product_id']] ?? ''));
            $productName = trim((string) ($row[$headerMap['product_name']] ?? ''));
            $categoriesValue = trim((string) ($row[$headerMap['categories']] ?? ''));

            if ($productId === '' || $productName === '') {
                $result['failed']++;
                $result['errors'][] = "ردیف {$rowNumber}: product_id یا product_name خالی است.";
                continue;
            }

            try {
                $categoryIds = $this->resolveCategories($categoriesValue, $lang);

                $product = Product::where('source_product_id', $productId)->first();
                $isNew = false;

                if (!$product) {
                    $isNew = true;
                    $product = new Product();
                    $product->source_product_id = $productId;
                    $product->type = 'physical';
                    $product->price_type = 'multiple-price';
                    $product->published = false;
                    $product->lang = $lang;
                }

                $product->title = $productName;
                $product->slug = $productName;
                $product->category_id = $categoryIds[0] ?? null;
                $product->admin_updated_at = now();
                $product->save();

                if (count($categoryIds)) {
                    $product->categories()->sync($categoryIds);
                }

                if ($isNew) {
                    $result['imported']++;
                } else {
                    $result['updated']++;
                }
            } catch (\Throwable $exception) {
                $result['failed']++;
                $result['errors'][] = "ردیف {$rowNumber}: " . $exception->getMessage();
            }
        }

        $result['skipped'] = max($result['total_rows'] - ($result['imported'] + $result['updated'] + $result['failed']), 0);

        Product::clearCache();

        return $result;
    }

    private function extractHeaderMap(array $header): array
    {
        $map = [];

        foreach ($header as $index => $column) {
            $normalized = Str::of((string) $column)->trim()->lower()->replace(' ', '_')->replace('-', '_')->value();
            if ($normalized !== '') {
                $map[$normalized] = $index;
            }
        }

        return $map;
    }

    private function isEmptyRow(array $row): bool
    {
        foreach ($row as $cell) {
            if (trim((string) $cell) !== '') {
                return false;
            }
        }

        return true;
    }

    private function resolveCategories(string $rawValue, string $lang): array
    {
        if ($rawValue === '') {
            return [];
        }

        $groups = preg_split('/[\n,;|]+/u', $rawValue) ?: [];
        $categoryIds = [];

        foreach ($groups as $group) {
            $group = trim($group);
            if ($group === '') {
                continue;
            }

            $parts = preg_split('/\s*(>|\/|\\\\)\s*/u', $group) ?: [];
            $parts = array_values(array_filter(array_map(fn($item) => trim($item), $parts)));

            if (!count($parts)) {
                continue;
            }

            $parentId = null;
            foreach ($parts as $part) {
                $category = Category::query()
                    ->where('type', 'productcat')
                    ->where('lang', $lang)
                    ->where('title', $part)
                    ->where('category_id', $parentId)
                    ->first();

                if (!$category) {
                    $category = Category::create([
                        'title' => $part,
                        'slug' => $part,
                        'type' => 'productcat',
                        'category_id' => $parentId,
                        'published' => true,
                        'lang' => $lang,
                    ]);
                }

                $parentId = $category->id;
            }

            if ($parentId) {
                $categoryIds[] = $parentId;
            }
        }

        return array_values(array_unique($categoryIds));
    }
}

