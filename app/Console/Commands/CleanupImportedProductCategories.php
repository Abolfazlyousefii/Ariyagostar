<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CleanupImportedProductCategories extends Command
{
    protected $signature = 'products:cleanup-imported-categories {--dry-run : Show the cleanup summary without changing data}';

    protected $description = 'Keep only Mobile and Guard product categories, reassign related products, and remove imported junk categories safely.';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');

        $summary = [
            'kept' => [],
            'removed' => [],
            'reassigned' => 0,
            'deleted_imported_products' => 0,
            'published_imported_products' => 0,
        ];

        $runner = function () use (&$summary) {
            $mainCategories = collect(['Mobile', 'Guard'])->mapWithKeys(function (string $title, int $index) {
                $category = Category::query()
                    ->where('type', 'productcat')
                    ->whereNull('category_id')
                    ->whereRaw('LOWER(title) = ?', [Str::lower($title)])
                    ->first();

                if (!$category) {
                    $category = Category::create([
                        'title' => $title,
                        'slug' => SlugService::createSlug(Category::class, 'slug', $title),
                        'type' => 'productcat',
                        'published' => true,
                        'lang' => app()->getLocale(),
                        'ordering' => $index + 1,
                    ]);
                } else {
                    $category->update([
                        'category_id' => null,
                        'published' => true,
                        'ordering' => $index + 1,
                    ]);
                }

                return [Str::lower($title) => $category];
            });

            $summary['kept'] = $mainCategories->values()->pluck('title')->all();

            $allProductCategories = Category::query()
                ->where('type', 'productcat')
                ->orderByDesc('category_id')
                ->orderBy('id')
                ->get();

            $removableCategories = $allProductCategories
                ->filter(function (Category $category) use ($mainCategories) {
                    return !$mainCategories->has(Str::lower($category->title));
                })
                ->values();

            $removableIds = $removableCategories->pluck('id')->all();

            foreach ($removableCategories as $category) {
                $summary['removed'][] = $category->title;

                $affectedProducts = Product::query()
                    ->where('category_id', $category->id)
                    ->orWhereHas('categories', function ($query) use ($category) {
                        $query->where('categories.id', $category->id);
                    })
                    ->with('categories:id,title')
                    ->get();

                foreach ($affectedProducts as $product) {
                    $targetCategory = $this->resolveTargetCategory($product, $category, $mainCategories);

                    $existingCategoryIds = $product->categories->pluck('id')->all();
                    $keptExisting = array_values(array_filter(
                        $existingCategoryIds,
                        fn (int $id) => !in_array($id, $removableIds, true)
                    ));

                    $finalCategoryIds = array_values(array_unique(array_merge($keptExisting, [$targetCategory->id])));

                    $product->categories()->sync($finalCategoryIds);

                    if (!$product->category_id || in_array($product->category_id, $removableIds, true)) {
                        $product->category_id = $targetCategory->id;
                    }

                    if ($product->external_product_id && !$product->published) {
                        $product->published = true;
                        $summary['published_imported_products']++;
                    }

                    $product->save();
                    $summary['reassigned']++;
                }

                $category->delete();
            }

            Product::query()
                ->whereNotNull('external_product_id')
                ->whereNull('category_id')
                ->update([
                    'category_id' => $mainCategories['mobile']->id,
                ]);

            $importedProducts = Product::query()
                ->whereNotNull('external_product_id')
                ->withCount(['prices', 'orders', 'categories'])
                ->get();

            foreach ($importedProducts as $product) {
                if (!$this->shouldDeleteImportedProduct($product)) {
                    continue;
                }

                $product->categories()->detach();
                $product->delete();
                $summary['deleted_imported_products']++;
            }

            $summary['published_imported_products'] += Product::query()
                ->whereNotNull('external_product_id')
                ->where('published', false)
                ->update([
                    'published' => true,
                ]);

            Cache::forget('front.productcats');
        };

        if ($dryRun) {
            DB::beginTransaction();
            $runner();
            DB::rollBack();
        } else {
            DB::transaction($runner);
        }

        $this->info('Kept categories: ' . implode(', ', $summary['kept']));
        $this->info('Removed categories: ' . (count($summary['removed']) ? implode(', ', $summary['removed']) : 'none'));
        $this->info('Products reassigned: ' . $summary['reassigned']);
        $this->info('Imported products deleted: ' . $summary['deleted_imported_products']);
        $this->info('Imported products published: ' . $summary['published_imported_products']);

        if ($dryRun) {
            $this->warn('Dry-run finished. No database changes were persisted.');
        }

        return self::SUCCESS;
    }

    private function resolveTargetCategory(Product $product, Category $sourceCategory, Collection $mainCategories): Category
    {
        $haystack = Str::lower(implode(' ', [
            $sourceCategory->title,
            $product->title,
            optional($product->category)->title,
        ]));

        if (Str::contains($haystack, ['guard', 'case', 'cover', 'گارد', 'کاور'])) {
            return $mainCategories['guard'];
        }

        return $mainCategories['mobile'];
    }

    private function shouldDeleteImportedProduct(Product $product): bool
    {
        $title = Str::lower(trim((string) $product->title));

        if ($title === '') {
            return true;
        }

        if (Str::startsWith($title, 'sample product')) {
            return true;
        }

        $hasNoCommercialData = (int) $product->prices_count === 0
            && (int) $product->orders_count === 0
            && blank($product->image);

        $hasNoEffectiveCategory = (int) $product->categories_count === 0 && !$product->category_id;

        return $hasNoCommercialData && $hasNoEffectiveCategory;
    }
}
