<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class DiscountController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        $cart = $user->cart;

        if (!$cart) {
            abort(404);
        }

        $request->validate([
            'code' => 'required|exists:discounts,code'
        ]);

        if ($cart->discount) {
            throw ValidationException::withMessages([
                'code' => trans('front::messages.controller.discount-code') 
            ]);
        }

        $discount = Discount::where('code', $request->code)->first();

        $can_use_discount = $cart->canUseDiscount($request->code);

        if (!$can_use_discount['status']) {
            throw ValidationException::withMessages([
                'code' => [$can_use_discount['message']]
            ]);
        }

        $cart->update([
            'discount_id' => $discount->id
        ]);

        return response('success');
    }

    public function destroy(Request $request)
    {
        $user = auth()->user();
        $cart = $user->cart;

        if (!$cart) {
            abort(404);
        }

        $cart->update([
            'discount_id' => null
        ]);

        toastr()->success( trans('front::messages.controller.remove-discount-order') );

        return redirect()->route('front.checkout');
    }
}
