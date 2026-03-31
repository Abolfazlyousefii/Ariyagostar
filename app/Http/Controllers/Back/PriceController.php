<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:products.prices');
    }

    public function index()
    {
        $brands     = Brand::orderBy('name')->select('id', 'name')->get();
        $categories = Category::detectLang()->where('type', 'productcat')->orderBy('ordering')->get();

        return view('back.prices.index', compact('brands', 'categories'));
    }

    public function show(Request $request)
    {
        $request->validate([
            'brand_id'    => 'required|exists:brands,id',
            'type'        => 'required|in:increase,decrease,discount,fake_discount,remove_fake_discount',
            'amount_type' => 'nullable|required_if:type,increase,decrease|in:percentage,price',
            'amount'      => 'nullable|required_if:type,increase,decrease|integer|gt:0',
            'discount'    => 'nullable|required_if:type,discount,fake_discount|integer|lt:100'
        ]);

        $brand    = Brand::find($request->brand_id);
        $products = $brand->products()->filter($request)->available()->published()->latest()->get();

        return view('back.prices.show', compact('brand', 'products', 'request'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'        => 'required|in:increase,decrease,discount,fake_discount,remove_fake_discount',
            'amount_type' => 'nullable|required_if:type,increase,decrease|in:percentage,price',
            'amount'      => 'nullable|required_if:type,increase,decrease|integer|gt:0',
            'discount'    => 'nullable|required_if:type,discount,fake_discount|integer|lt:100',
            'products'    => 'required|array'
        ], [
            'products.required' => 'لطفا محصولات را انتخاب کنید!'
        ]);

        $prices = Price::where('stock', '>', 0)->whereIn('product_id', $request->products)->get();

        foreach ($prices as $price) {
            $new_price = getNewPrice($request, $price);

            $price->update($new_price);

            $product                   = $price->product;
            $product->admin_updated_at = now();
            $product->save();
        }

        toastr()->success('تغییر قیمت گروهی با موفقیت انجام شد.');

        return response('success');
    }
}
