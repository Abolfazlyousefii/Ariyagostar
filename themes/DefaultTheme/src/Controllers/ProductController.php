<?php

namespace Themes\DefaultTheme\src\Controllers;

use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Price;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Models\AttributeGroup;
use Illuminate\Validation\Rule;
use App\Models\SpecificationGroup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::detectLang()
            ->published()
            ->whereNull('Category_id')
            ->where('type', 'productcat')
            ->with(['childrenCategories' => function ($query) {
                $query->published()->where('type', 'productcat')->orderBy('ordering');
            }])
            ->orderBy('ordering')
            ->get();

        $selectedCategory = null;
        $subCategories = collect();

        if ($request->filled('category_id')) {
            $selectedCategory = Category::detectLang()
                ->published()
                ->where('type', 'productcat')
                ->find($request->integer('category_id'));

            if ($selectedCategory) {
                $subCategories = $selectedCategory->childrenCategories;
            }
        }

        $productsQuery = Product::detectLang()
            ->published()
            ->orderByStock()
            ->with(['category', 'brand', 'labels', 'lowestPrice']);

        if ($request->filled('s') && is_string($request->s)) {
            $productsQuery->search($request->s);
        }

        if ($selectedCategory) {
            $productsQuery->whereIn('category_id', $selectedCategory->allChildCategories());
        }

        if ($request->filled('child_category_id')) {
            $childCategory = Category::detectLang()
                ->published()
                ->where('type', 'productcat')
                ->find($request->integer('child_category_id'));

            if ($childCategory) {
                $productsQuery->whereIn('category_id', $childCategory->allChildCategories());
            }
        }

        if ($request->filled('brand_id')) {
            $productsQuery->where('brand_id', $request->integer('brand_id'));
        }

        if ($request->stock_status === 'in_stock') {
            $productsQuery->available();
        }

        if ($request->stock_status === 'out_of_stock') {
            $productsQuery->unavailable();
        }

        if ($request->boolean('discounted')) {
            $productsQuery->discount();
        }

        if ($request->filled('min_price')) {
            $productsQuery->whereHas('prices', function ($query) use ($request) {
                $query->where('stock', '>', 0)->where('price', '>=', $request->integer('min_price'));
            });
        }

        if ($request->filled('max_price')) {
            $productsQuery->whereHas('prices', function ($query) use ($request) {
                $query->where('stock', '>', 0)->where('price', '<=', $request->integer('max_price'));
            });
        }

        switch ($request->input('sort_type', 'latest')) {
            case 'view':
                $productsQuery->orderBy('view', 'desc');
                break;
            case 'sale':
                $productsQuery->orderBySale('desc');
                break;
            case 'cheapest':
                $productsQuery->orderByPrice('asc');
                break;
            case 'expensivest':
                $productsQuery->orderByPrice('desc');
                break;
            default:
                $productsQuery->latest();
                break;
        }

        $brands = Brand::detectLang()
            ->whereHas('products', function ($query) {
                $query->detectLang()->published();
            })
            ->orderBy('name')
            ->get();

        $priceRange = Price::query()
            ->where('stock', '>', 0)
            ->whereHas('product', function ($query) {
                $query->detectLang()->published();
            })
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        $products = $productsQuery
            ->paginate(30)
            ->withQueryString();

        return view('front::products.index', compact(
            'brands',
            'categories',
            'products',
            'selectedCategory',
            'subCategories',
            'priceRange',
        ));
    }

    public function category(Category $category)
    {
        $this->isShowable($category);

        if ($category->childrenCategories()->published()->count()) {
            return view('front::products.category', compact('category'));
        }

        return redirect()->route('front.products.category-products', ['category' => $category]);
    }

    public function categoryProducts(Category $category)
    {
        $this->isShowable($category);

        return $this->renderCategoryProductsPage($category);
    }

    public function section(Category $parent, Category $child)
    {
        $this->isShowable($parent);
        $this->isShowable($child);

        if ((int) $child->category_id !== (int) $parent->id || $parent->type !== 'productcat' || $child->type !== 'productcat') {
            abort(404);
        }

        return $this->renderCategoryProductsPage($child);
    }

    private function renderCategoryProductsPage(Category $category)
    {
        $ids       = $category->allPublishedProducts()->pluck('id');
        $products  = Product::orderByStock()->frontFilter($category)->latest()->whereIn('products.id', $ids)->paginate(20);
        $min_price = Price::where('stock', '>', 0)->whereIn('product_id', $ids)->min('price');
        $max_price = Price::where('stock', '>', 0)->whereIn('product_id', $ids)->max('price');

        return view('front::products.category-products', compact('products', 'category', 'min_price', 'max_price'));
    }

    public function categorySpecials(Category $category)
    {
        $this->isShowable($category);

        $products = Product::detectLang()
            ->published()
            ->special()
            ->whereIn('category_id', $category->allChildCategories())
            ->latest()
            ->paginate(20);

        return view('front::products.category-products', compact(
            'products',
            'category'
        ));
    }

    public function search(Request $request)
    {
        $products = Product::detectLang()
            ->published()
            ->search($request->q)
            ->orderByStock()
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('front::products.search', compact('products'));
    }

    public function specials()
    {
        $products = Product::detectLang()
            ->published()
            ->special()
            ->latest()
            ->paginate(20);

        return view('front::products.specials', compact('products'));
    }

    public function discount()
    {
        $products = Product::detectLang()
            ->published()
            ->available()
            ->discount()
            ->latest()
            ->paginate(20);

        return view('front::products.discounts', compact('products'));
    }

    public function ajax_search(Request $request)
    {
        $products = Product::detectLang()
            ->published()
            ->search($request->q)
            ->orderByStock()
            ->latest()
            ->take(7)
            ->get();

        $results = [];

        foreach ($products as $product) {
            $results[] = [
                'title'      => $product->title,
                'link'       => route('front.products.show', ['product' => $product]),
                'image'      => $product->image ? asset($product->image) : asset('/no-image-product.png'),
                'category'   => $product->category ? $product->category->title :  trans('front::messages.controller.no-category'),
                'price'      => $product->getLowestPrice(),
            ];
        }

        return response($results);
    }

    public function show(Product $product)
    {
        if (!$product->isShowable()) {
            abort(404);
        }

        if ($product->category) {
            $related_products = Product::published()
                ->where('id', '!=', $product->id)
                ->where('category_id', $product->category->id)
                ->orderByStock()
                ->latest()
                ->take(6)
                ->get();
        } else {
            $related_products = Product::published()
                ->where('id', '!=', $product->id)
                ->whereNull('category_id')
                ->orderByStock()
                ->latest()
                ->take(6)
                ->get();
        }

        $product->load(['comments' => function ($query) {
            $query->whereNull('comment_id')->where('status', 'accepted')->latest();
        }]);

        $reviews = $product->reviews()
            ->accepted()
            ->latest()
            ->take(10)
            ->get();

        $selected_price = $product->getPrices()->first();

        $attributeGroups = AttributeGroup::detectLang()->orderBy('ordering')->get();

        $similar_products_count = Product::whereNotIn('id', [$product->id])
            ->whereNotNull('spec_type_id')
            ->where('spec_type_id', $product->spec_type_id)
            ->published()
            ->count();

        $show_prices_chart = option('dt_show_price_change_chart', 'yes') == 'yes';

        $product->increaseViewCount();

        return view('front::products.show', compact(
            'product',
            'related_products',
            'attributeGroups',
            'similar_products_count',
            'selected_price',
            'show_prices_chart',
            'reviews',
        ));
    }

    public function download(Price $price, Request $request)
    {
        if (!$price->product->isDownload()) {
            abort(404);
        }

        if (!$price->isDownloadable()) {
            abort(403);
        }

        $mac     = $request->mac;
        $time    = $request->time;
        $expired = Carbon::now()->addHours(5)->getTimestamp() < $time;
        $hash    = config('app.key') . $time . $price->id;

        $check   = Hash::check($hash, $mac);
        $file    = $price->file;

        if (!$file || !Storage::disk($file->disk)->exists('product-files/' . $file->file)) {
            return view('front::errors.errors')->with('message', 'فایل یافت نشد');
        }

        if ($check && !$expired) {
            return Storage::disk($file->disk)->download('product-files/' . $file->file);
        }

        return view('front::errors.errors')->with('message',  trans('front::messages.controller.download-link-failed'));
    }

    public function comments(Product $product, Request $request)
    {
        $this->validate($request, [
            'body'       => 'required|string|max:1000',
            'comment_id' => [
                'nullable',
                Rule::exists('comments', 'id')->where(function ($query) {
                    $query->where('comment_id', null);
                }),
            ],
        ]);

        $comment = $product->comments()->create([
            'body'       => $request->body,
            'comment_id' => $request->comment_id,
            'user_id'    => auth()->user()->id
        ]);

        if (auth()->user()->isAdmin()) {
            $comment->update([
                'status' => 'accepted'
            ]);
        }

        return response('success');
    }

    public function prices(Product $product, Request $request)
    {
        $request->validate([
            'groups' => 'required|array',
            'groups.*' => 'required|exists:attributes,id'
        ]);

        $query = $product->getPrices();
        $count = 0;
        $attributeGroups = AttributeGroup::detectLang()->orderBy('ordering')->get();


        do {
            $query = $query->whereHas('get_attributes', function ($q) use ($request, $count) {
                $q->where('attribute_id', $request->groups[$count]);
            });

            $query2 = clone $query;

            if (isset($request->groups[$count + 1])) {
                $query2 = $query2->whereHas('get_attributes', function ($q) use ($request, $count) {
                    $q->where('attribute_id', $request->groups[$count + 1]);
                })->first();
            }

            if (!$query2 || !isset($request->groups[$count + 1])) {
                break;
            }

            $count++;
        } while (true);

        $selected_price = $query->first();

        return view('front::products.partials.product-info', compact(
            'product',
            'selected_price',
            'attributeGroups'
        ));
    }

    public function compare($product1, $product2 = null, $product3 = null)
    {
        $product1 = Product::whereHas('specType')->findOrFail($product1);
        $products[] = $product1;
        $products_id[] = $product1->id;

        $groups_id = $product1->specificationGroups()->pluck('specification_groups.id')->unique()->toArray();

        if ($product2) {
            $product2 = Product::whereNotIn('id', $products_id)->where('spec_type_id', $product1->spec_type_id)->findOrFail($product2);
            $products[] = $product2;
            $products_id[] = $product2->id;

            $groups_id = array_merge($groups_id, $product2->specificationGroups()->pluck('specification_groups.id')->unique()->toArray());
        }

        if ($product3) {
            $product3 = Product::whereNotIn('id', $products_id)->where('spec_type_id', $product1->spec_type_id)->findOrFail($product3);
            $products[] = $product3;

            $groups_id = array_merge($groups_id, $product3->specificationGroups()->pluck('specification_groups.id')->unique()->toArray());
        }

        $groups_id = array_unique($groups_id);
        $products = collect($products);

        $groups = SpecificationGroup::whereIn('id', $groups_id)->orderByRaw('FIELD(id,' . implode(',', $groups_id) . ')')->get();

        return view('front::products.compare', compact('groups', 'products'));
    }

    public function similarCompare(Request $request)
    {
        $request->validate([
            'search'     => 'required|string',
            'products'   => 'required|array',
            'products.*' => 'required|exists:products,id',
            'current_url' => 'required|string',
        ]);

        $current_url = $request->current_url;
        $products_id = $request->products;
        $spec_type = Product::find(reset($products_id))->spec_type_id;

        $similar_products = Product::detectLang()->published()->whereNotIn('id', $products_id)
            ->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')->orWhere('title', 'like', '%' . $request->search . '%');
            })
            ->where('spec_type_id', $spec_type)
            ->orderByStock()
            ->take(20)
            ->get();

        $products = Product::whereIn('id', $products_id)->get();

        return view('front::products.partials.compare-modal', compact('similar_products', 'products', 'current_url'));
    }

    public function priceChart(Price $price)
    {
        $data = $this->getPriceData($price);

        return response()->json(['data' => $data]);
    }

    private function getPriceData($price)
    {
        $data = [];

        for ($i = 0; $i <= 30; $i++) {
            $date             = Jalalian::now()->subDays($i)->format('%d %B');
            $data[$i]['date'] = $date;

            $last_date = $price->changes()
                ->whereDate('price_changes.created_at', '<=', now()->subDays($i))
                ->latest('price_changes.created_at')
                ->first();

            if (!$last_date) {
                $data[$i]['price']          = null;
                $data[$i]['discount_price'] = null;
                $data[$i]['discount']       = null;

                continue;
            }

            $last_min_price = $price->changes()->whereDate('price_changes.created_at', $last_date->created_at)->orderBy(DB::raw("`price` - (`price` * `discount` / 100)"))->first();
            $data[$i]['price']          = $last_min_price->price;
            $data[$i]['discount_price'] = $last_min_price->price - ($last_min_price->price * $last_min_price->discount / 100);
            $data[$i]['discount']       = $last_min_price->discount;
        }

        return $data;
    }

    private function isShowable(Category $category)
    {
        if ($category->type != 'productcat' || !$category->isPublished()) {
            abort(404);
        }
    }

    public function shortLink($id)
    {
        $product = Product::findOrfail($id);

        return redirect()->route('front.products.show', ['product' => $product]);
    }
}
