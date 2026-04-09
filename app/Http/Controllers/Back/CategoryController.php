<?php

namespace App\Http\Controllers\Back;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public $ordering = 1;

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'type'  => 'required|string|in:productcat,postcat',
            'slug'  => 'nullable|unique:categories,slug',
        ]);

        $this->authorizeCategory($request->type);

        $category = Category::create([
            'title' => $request->title,
            'lang'  => app()->getLocale(),
            'type'  => $request->type,
            'slug'  => $request->slug ?: $request->title,
        ]);

        return response()->json($category);
    }

    public function edit(Category $category)
    {
        $this->authorizeCategory($category->type);

        if ($category->type == 'productcat') {
            return view('back.products.categories.edit', compact('category'));
        }

        return view('back.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeCategory($category->type);

        $this->validate($request, [
            'title' => 'required|string',
            'image' => 'image',
            'slug'  => "nullable|unique:categories,slug,$category->id",
        ]);

        $category->update([
            'title'            => $request->title,
            'slug'             => $request->slug ?: $request->title,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'description'      => $request->description,
            'filter_type'      => $request->filter_type ?: 'inherit',
            'filter_id'        => $request->filter_id,
            'published'        => $request->has('published'),
        ]);

        if ($request->hasFile('image')) {
            $file = $request->image;
            $name = uniqid() . '_' . $category->id . '.' . $file->getClientOriginalExtension();
            $request->image->storeAs('categories', $name);

            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $category->image = '/uploads/categories/' . $name;
            $category->save();
        }

        if ($request->hasFile('background_image')) {
            $file = $request->background_image;
            $name = uniqid() . '_' . $category->id . '.' . $file->getClientOriginalExtension();
            $request->background_image->storeAs('categories', $name);

            if ($category->background_image) {
                Storage::disk('public')->delete($category->background_image);
            }

            $category->background_image = '/uploads/categories/' . $name;
            $category->save();
        }

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $this->authorizeCategory($category->type);

        $this->deleteCategoryTree($category);

        toastr()->success('دسته‌بندی با موفقیت حذف شد.');

        return redirect()->route($category->type == 'productcat' ? 'admin.products.categories.index' : 'admin.posts.categories.index');
    }

    public function bulkDestroy(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|string|in:productcat,postcat',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'integer|exists:categories,id',
        ]);

        $this->authorizeCategory($request->type);

        $selectedIds = collect($request->category_ids)->map(fn ($id) => (int) $id)->unique()->values();

        $categories = Category::query()
            ->whereIn('id', $selectedIds)
            ->where('type', $request->type)
            ->get();

        if ($categories->isEmpty()) {
            return response()->json([
                'message' => 'هیچ دسته‌بندی معتبری برای حذف انتخاب نشده است.',
            ], 422);
        }

        $categoryMap = Category::query()
            ->where('type', $request->type)
            ->select('id', 'category_id', 'title')
            ->get();

        $childrenByParent = $categoryMap
            ->groupBy('category_id')
            ->map(fn ($items) => $items->pluck('id')->all());

        $selectedLookup = $selectedIds->flip();
        $rootCandidates = $categories->filter(function (Category $category) use ($selectedLookup) {
            return !$category->category_id || !$selectedLookup->has((int) $category->category_id);
        });

        $deletedTitles = [];
        $blocked = [];

        DB::transaction(function () use ($rootCandidates, $childrenByParent, &$deletedTitles, &$blocked) {
            foreach ($rootCandidates as $category) {
                $treeIds = $this->collectCategoryTreeIds($category->id, $childrenByParent);

                $relationStats = $this->getBlockingRelationStats($category->type, $treeIds);

                if ($relationStats['has_blocking_relation']) {
                    $blocked[] = [
                        'title' => $category->title,
                        'reason' => $relationStats['reason'],
                    ];
                    continue;
                }

                $this->deleteCategoryTree($category, $treeIds);
                $deletedTitles[] = $category->title;
            }
        });

        if (empty($deletedTitles) && !empty($blocked)) {
            return response()->json([
                'message' => 'هیچ دسته‌بندی حذف نشد. برخی دسته‌بندی‌های انتخابی به داده‌های وابسته متصل هستند.',
                'blocked' => $blocked,
                'deleted_count' => 0,
                'blocked_count' => count($blocked),
            ], 422);
        }

        $message = sprintf('حذف گروهی انجام شد. %s دسته‌بندی حذف شد.', count($deletedTitles));

        if (!empty($blocked)) {
            $message .= sprintf(' %s دسته‌بندی به‌دلیل ارتباط داده‌ای حذف نشد.', count($blocked));
        }

        return response()->json([
            'message' => $message,
            'deleted' => $deletedTitles,
            'deleted_count' => count($deletedTitles),
            'blocked' => $blocked,
            'blocked_count' => count($blocked),
        ]);
    }

    public function sort(Request $request)
    {
        $this->validate($request, [
            'categories' => 'required|array',
            'type'       => 'required|in:productcat,postcat',
        ]);

        $this->authorizeCategory($request->type);

        $categories = $request->categories;

        $this->sort_category($categories);

        return response()->json('success');
    }
    private function sort_category($categories, $category_id = null)
    {
        foreach ($categories as $category) {
            Category::find($category['id'])->update(['category_id' => $category_id, 'ordering' => $this->ordering++]);
            if (array_key_exists('children', $category)) {
                $this->sort_category($category['children'], $category['id']);
            }
        }
    }

    private function authorizeCategory($type)
    {
        switch ($type) {
            case "postcat":
                $this->authorize('posts.category');
                break;
            case "productcat":
                $this->authorize('products.category');
                break;
        }
    }

    private function collectCategoryTreeIds(int $categoryId, $childrenByParent): array
    {
        $treeIds = [$categoryId];
        $stack = [$categoryId];

        while (!empty($stack)) {
            $current = array_pop($stack);
            $children = $childrenByParent->get($current, []);

            foreach ($children as $childId) {
                if (!in_array($childId, $treeIds, true)) {
                    $treeIds[] = $childId;
                    $stack[] = $childId;
                }
            }
        }

        return $treeIds;
    }

    private function deleteCategoryTree(Category $category, ?array $treeIds = null): void
    {
        $treeIds = $treeIds ?: $category->allChildCategories();

        $categories = Category::query()
            ->whereIn('id', $treeIds)
            ->orderByRaw('category_id IS NULL ASC')
            ->get();

        foreach ($categories as $categoryItem) {
            if ($categoryItem->image) {
                Storage::disk('public')->delete($categoryItem->image);
            }
            if ($categoryItem->background_image) {
                Storage::disk('public')->delete($categoryItem->background_image);
            }

            $categoryItem->menus()->detach();
            $categoryItem->delete();
        }
    }

    private function getBlockingRelationStats(string $type, array $treeIds): array
    {
        if ($type === 'postcat') {
            $postsCount = DB::table('posts')->whereIn('category_id', $treeIds)->count();

            return [
                'has_blocking_relation' => $postsCount > 0,
                'reason' => "اتصال به {$postsCount} نوشته",
            ];
        }

        $primaryProductCount = DB::table('products')->whereIn('category_id', $treeIds)->count();
        $pivotProductCount = DB::table('category_product')->whereIn('category_id', $treeIds)->count();
        $totalProductRelations = $primaryProductCount + $pivotProductCount;

        return [
            'has_blocking_relation' => $totalProductRelations > 0,
            'reason' => "اتصال به {$totalProductRelations} رابطه محصول",
        ];
    }

    public function generate_slug(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $slug = SlugService::createSlug(Category::class, 'slug', $request->title);

        return response()->json(['slug' => $slug]);
    }
}
