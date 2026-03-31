<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use App\Models\Gateway;
use App\Models\Province;
use App\Models\Widget;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $widgets = Widget::detectLang()->with('options')
            ->where('theme', current_theme_name())
            ->where('is_active', true)
            ->orderBy('ordering')
            ->get();

        return view('front::index', compact('widgets'));
    }

    public function checkout()
    {
        $cart     = auth()->user()->cart;
        $gateways = Gateway::active()->orderBy('ordering')->get();

        if (!$cart || !$cart->products->count() || !check_cart_quantity()) {
            return redirect()->route('front.cart');
        }

        $discount_status = check_cart_discount();

        $provinces       = Province::detectLang()->active()->orderBy('ordering')->get();
        $wallet          = auth()->user()->getWallet();
        $carriers        = Carrier::detectLang()->active()->latest()->get();

        return view('front::checkout', compact(
            'provinces',
            'discount_status',
            'gateways',
            'wallet',
            'carriers'
        ));
    }

    public function reserveCart(Request $request)
    {
        $cart = auth()->user()->cart;

        $request->validate([
            'reserve' => 'nullable|in:reserve,send_reserved_orders,no-reserve',
        ]);

        switch ($request->reserve) {
            case "reserve": {
                    $cart->update([
                        'reserve'              => true,
                        'send_reserved_orders' => false,
                    ]);

                    break;
                }
            case "send_reserved_orders": {
                    $cart->update([
                        'reserve'              => false,
                        'send_reserved_orders' => true,
                    ]);

                    break;
                }
            default: {
                    $cart->update([
                        'reserve'              => false,
                        'send_reserved_orders' => false,
                    ]);
                }
        }

        return response('success');
    }

    public function getPrices(Request $request)
    {
        $cart = auth()->user()->cart;

        if ($request->city_id) {
            $request->validate([
                'city_id' => 'required|exists:cities,id',
            ]);
        }

        if ($request->carrier_id) {
            $request->validate([
                'carrier_id' => 'required|exists:carriers,id',
            ]);
        }

        $carriers = Carrier::detectLang()->active()->latest()->get();

        $cart->update([
            'city_id'    => $request->city_id,
            'carrier_id' => $request->carrier_id,
        ]);

        return [
            'checkout_sidebar'   => view('front::partials.checkout-sidebar')->render(),

            'carriers_container' => view('front::partials.carriers-container', [
                'cart'           => $cart,
                'carriers'       => $carriers
            ])->render(),
        ];
    }

    public function captcha()
    {
        return response(['captcha' => captcha_src('flat')]);
    }
}
