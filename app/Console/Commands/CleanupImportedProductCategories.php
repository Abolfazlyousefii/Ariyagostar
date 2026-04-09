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

    protected $description = 'Normalize product categories so only گارد and موبایل remain, while safely reassigning relations.';

    private const CATEGORY_MAP = [
        'guard' => [
            'title' => 'گارد',
            'slug' => 'guard',
            'keywords' => ['guard', 'case', 'cover', 'bumper', 'گارد', 'کاور', 'قاب'],
        ],
        'mobile' => [
            'title' => 'موبایل',
            'slug' => 'mobile',
            'keywords' => ['mobile', 'phone', 'smartphone', 'cell', 'موبایل', 'گوشی'],
        ],
    ];

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');

        $summary = [
            'kept' => [],
            'created' => [],
            'removed' => [],
            'products_reassigned' => 0,
            'products_primary_updated' => 0,
            'menu_items_deleted' => 0,
            'detached_pivot_relations' => 0,
        ];

        $runner = function () use (&$summary): void {
            $keepers = $this->ensureKeeperCategories($summary);
            $keeperIds = $keepers->pluck('id')->values()->all();

            $removableCategories = Category::query()
                ->where('type', 'productcat')
                ->whereNotIn('id', $keeperIds)
                ->orderByDesc('category_id')
                ->orderBy('id')
                ->get();

            $removableIds = $removableCategories->pluck('id')->all();
            $summary['removed'] = $removableCategories->pluck('title')->unique()->values()->all();

            if (!empty($removableIds)) {
                $summary['menu_items_deleted'] = DB::table('menus')
                    ->where('type', 'category')
                    ->whereIn('menuable_id', $removableIds)
                    ->delete();

                $affectedProducts = Product::query()
                    ->whereIn('category_id', $removableIds)
                    ->orWhereHas('categories', function ($query) use ($removableIds) {
                        $query->whereIn('categories.id', $removableIds);
                    })
                    ->with(['category:id,title', 'categories:id,title'])
                    ->get();

                foreach ($affectedProducts as $product) {
                    $oldPrimaryCategoryId = $product->category_id;
                    $oldCategoryIds = $product->categories->pluck('id')->all();

                    $target = $this->resolveTargetCategory($product, $keepers);

                    $remainingCategoryIds = array_values(array_filter(
                        $oldCategoryIds,
                        static fn (int $id) => !in_array($id, $removableIds, true)
                    ));

                    $finalCategoryIds = array_values(array_unique(array_merge($remainingCategoryIds, [$target->id])));

                    $removedFromPivot = count(array_diff($oldCategoryIds, $finalCategoryIds));
                    $summary['detached_pivot_relations'] += max(0, $removedFromPivot);

                    $product->categories()->sync($finalCategoryIds);
                    $summary['products_reassigned']++;

                    if (!$product->category_id || in_array($product->category_id, $removableIds, true)) {
                        $product->category_id = $target->id;
                        $summary['products_primary_updated']++;
                    }

                    if ($product->category_id !== $oldPrimaryCategoryId) {
                        $product->save();
                    }
                }

                Category::query()
                    ->whereIn('id', $removableIds)
                    ->delete();
            }

            // Ensure final canonical structure for root categories.
            $keepers['guard']->update([
                'title' => self::CATEGORY_MAP['guard']['title'],
                'slug' => $this->generateUniqueSlug(self::CATEGORY_MAP['guard']['slug'], $keepers['guard']->id),
                'category_id' => null,
                'type' => 'productcat',
                'published' => true,
                'ordering' => 1,
            ]);

            $keepers['mobile']->update([
                'title' => self::CATEGORY_MAP['mobile']['title'],
                'slug' => $this->generateUniqueSlug(self::CATEGORY_MAP['mobile']['slug'], $keepers['mobile']->id),
                'category_id' => null,
                'type' => 'productcat',
                'published' => true,
                'ordering' => 2,
            ]);

            // Backfill products that accidentally have no primary category.
            Product::query()
                ->whereNull('category_id')
                ->update([
                    'category_id' => $keepers['mobile']->id,
                ]);

            foreach ((array) config('front.cache-forget.categories', []) as $cacheKey) {
                Cache::forget($cacheKey);
            }

            Cache::forget('front.productcats');
            Cache::forget('front.index.categories');
        };

        if ($dryRun) {
            DB::beginTransaction();
            $runner();
            DB::rollBack();
        } else {
            DB::transaction($runner);
        }

        $summary['kept'] = array_map(static fn (array $item) => $item['title'], self::CATEGORY_MAP);

        $this->info('Kept categories: ' . implode('، ', $summary['kept']));
        $this->info('Created categories: ' . (count($summary['created']) ? implode('، ', $summary['created']) : 'none'));
        $this->info('Removed categories: ' . (count($summary['removed']) ? implode('، ', $summary['removed']) : 'none'));
        $this->info('Products reassigned (pivot): ' . $summary['products_reassigned']);
        $this->info('Products primary category updated: ' . $summary['products_primary_updated']);
        $this->info('Detached obsolete pivot relations: ' . $summary['detached_pivot_relations']);
        $this->info('Deleted category menu items: ' . $summary['menu_items_deleted']);

        if ($dryRun) {
            $this->warn('Dry-run finished. No database changes were persisted.');
        }

        return self::SUCCESS;
    }

    private function ensureKeeperCategories(array &$summary): Collection
    {
        $preferredLang = Category::query()
            ->where('type', 'productcat')
            ->whereNotNull('lang')
            ->value('lang') ?? app()->getLocale();

        return collect(['guard', 'mobile'])->mapWithKeys(function (string $key) use (&$summary, $preferredLang): array {
            $config = self::CATEGORY_MAP[$key];

            $category = Category::query()
                ->where('type', 'productcat')
                ->where(function ($query) use ($config) {
                    $query->whereRaw('LOWER(title) = ?', [Str::lower($config['title'])])
                        ->orWhereRaw('LOWER(slug) = ?', [Str::lower($config['slug'])]);
                })
                ->first();

            if (!$category) {
                $category = Category::create([
                    'title' => $config['title'],
                    'slug' => $this->generateUniqueSlug($config['slug']),
                    'type' => 'productcat',
                    'published' => true,
                    'lang' => $preferredLang,
                    'ordering' => $key === 'guard' ? 1 : 2,
                ]);

                $summary['created'][] = $category->title;
            }

            return [$key => $category];
        });
    }

    private function resolveTargetCategory(Product $product, Collection $keepers): Category
    {
        $haystack = Str::lower(implode(' ', [
            $product->title,
            (string) optional($product->category)->title,
            implode(' ', $product->categories->pluck('title')->all()),
        ]));

        foreach (self::CATEGORY_MAP['guard']['keywords'] as $keyword) {
            if (Str::contains($haystack, Str::lower($keyword))) {
                return $keepers['guard'];
            }
        }

        return $keepers['mobile'];
    }

    private function generateUniqueSlug(string $preferredSlug, ?int $ignoreCategoryId = null): string
    {
        $query = Category::query()->where('slug', $preferredSlug);

        if ($ignoreCategoryId) {
            $query->where('id', '!=', $ignoreCategoryId);
        }

        if (!$query->exists()) {
            return $preferredSlug;
        }

        return SlugService::createSlug(Category::class, 'slug', $preferredSlug, ['unique' => true]);
    }
}
