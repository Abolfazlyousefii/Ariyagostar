<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Cart\StoreCartRequest;
use App\Http\Resources\Api\V1\Cart\CartResource;
use App\Models\Cart;
use App\Models\Price;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $this->getCart($request);

        return $this->respondWithResource(new CartResource($cart));
    }

    public function store(StoreCartRequest $request)
    {
        $cart    = $this->getCart($request);
        $price   = Price::find($request->price_id);
        $product = $price->product;

        $cart_product = $cart->products()->where('price_id', $price->id)->first();

        if ($cart_product && $product->isDownload()) {
            return response([
                'status' => 'error',
                'message' => 'این فایل قبلا در سبد اضافه شده است'
            ]);
        }

        $quantity     = $cart_product ? $request->quantity + $cart_product->pivot->quantity : $request->quantity;

        $stock_status = $price->hasStock($quantity);

        if (!$stock_status['status']) {
            return $this->respondError($stock_status['message'], 422);
        }

        $cart->products()->syncWithoutDetaching([
            $product->id => [
                'quantity'   => $quantity,
                'price_id'   => $price->id
            ],
        ]);

        return $this->respondSuccess('با موفقیت به سبد خرید اضافه شد.');
    }

    public function destroy(Request $request, $price)
    {
        $cart = $this->getCart($request);

        $cart->prices()->detach([$price]);

        return $this->respondSuccess('با موفقیت از سبد خرید حذف شد');
    }

    private function getCart(Request $request)
    {
        $cart = null;

        if ($request->user()) {
            $cart = $request->user()->getCart();
        } else {

            $cart_id = $request->header('cart-id');

            if ($cart_id) {
                try {
                    $cart_id = Crypt::decryptString($cart_id);
                    $cart    = Cart::find($cart_id);
                } catch (Exception $e) {
                    $cart_id = null;
                }
            }
        }

        if (!$cart) {
            $cart = Cart::create();
        }

        return $cart;
    }
}
