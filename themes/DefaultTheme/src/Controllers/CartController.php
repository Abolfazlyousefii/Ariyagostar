<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    public function show()
    {
        $city_id = auth()->check() && auth()->user()->address  ? auth()->user()->address->city_id : null;

        return view('front::cart', compact('city_id'));
    }

    public function store(Product $product, Request $request)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        if ($product->isSinglePrice()) {
            $price = $product->getPrices()->first();
        } else {
            $request->validate([
                'price_id' => ['required', Rule::exists('prices', 'id')->where('product_id', $product->id)->where('deleted_at', null)]
            ]);

            $price = $product->prices()->find($request->price_id);
        }

        // create or get user cart
        if (auth()->check()) {
            $cart = auth()->user()->getCart();
        } else {
            $cart_id = Cookie::get('cart_id');

            if (!$cart_id || !($cart = Cart::find($cart_id)) || $cart->user_id != null) {
                $cart = Cart::create([
                    'user_id' => null,
                ]);
            }

            Cookie::queue(Cookie::make('cart_id', $cart->id));
        }

        $cart_product = $cart->products()->where('product_id', $product->id)->where('price_id', $price->id)->first();

        if (!$cart_product) {

            $stock_status = $price->hasStock($request->quantity);

            if (!$stock_status['status']) {
                return response(['status' => 'error', 'message' => $stock_status['message']]);
            }

            $cart->products()->attach([
                $product->id => [
                    'product_id' => $product->id,
                    'quantity'   => $request->quantity,
                    'price_id'   => $price->id
                ],
            ]);
        } else {

            if ($product->isDownload()) {
                return response([
                    'status' => 'error',
                    'message' => trans('front::messages.controller.this-file-is-in-cart') 
                ]);
            }

            $stock_status = $price->hasStock($request->quantity + $cart_product->pivot->quantity);

            if (!$stock_status['status']) {
                return response(['status' => 'error', 'message' => $stock_status['message']]);
            }

            $cart->products()->where('product_id', $product->id)->where('price_id', $price->id)->update([
                'quantity'   => $cart_product->pivot->quantity + $request->quantity,
            ]);
        }

        return response(['status' => 'success', 'cart' => view('front::partials.cart')->with('render_cart', $cart)->render()]);
    }

    public function update(Request $request)
    {
        $cart = get_cart();

        $errors = [];

        foreach ($cart->products as $product) {

            $price     = $product->prices()->find($product->pivot->price_id);
            $quantity  = $request->input('product-' . $product->pivot->id);
            $has_stock = $price->hasStock($quantity, true);

            if (!$has_stock['status']) {
                $errors[] = $has_stock['message'];
            }
        }

        if (!empty($errors)) {
            return response(['errors' => $errors], 406);
        }

        foreach ($cart->products as $product) {
            $quantity = $request->input('product-' . $product->pivot->id);

            if ($quantity === '0') {
                DB::table('cart_product')->where('cart_id', $cart->id)->where('id', $product->pivot->id)->delete();
            } else if (intval($quantity) && $product->isPhysical()) {
                DB::table('cart_product')->where('cart_id', $cart->id)->where('id', $product->pivot->id)->update([
                    'quantity' => $quantity,
                ]);
            }
        }

        return response('success');
    }

    public function destroy($id)
    {
        $cart = get_cart();

        if ($cart) {
            DB::table('cart_product')->where('cart_id', $cart->id)->where('id', $id)->delete();
        }

        return redirect()->route('front.cart');
    }
}
