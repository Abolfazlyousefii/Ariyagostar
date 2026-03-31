<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Events\OrderCreated;
use App\Events\OrderPaid;
use App\Http\Controllers\Controller;
use App\Jobs\CancelOrder;
use App\Models\Carrier;
use App\Models\Cart;
use App\Models\City;
use App\Models\Gateway;
use App\Models\Order;
use App\Models\Province;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WalletHistory;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Invoice;
use Themes\DefaultTheme\src\Requests\StoreOrderRequest;
use App\Notifications\Order\OrderPaid as NotificationsOrderPaid;
use Themes\DefaultTheme\src\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);

        return view('front::user.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id != auth()->user()->id) {
            abort(404);
        }

        $gateways = Gateway::active()->get();
        $wallet   = auth()->user()->getWallet();

        return view('front::user.orders.show', compact(
            'order',
            'gateways',
            'wallet'
        ));
    }

    public function store(StoreOrderRequest $request)
    {
        $user = auth()->user();

        $cart = $user->cart;

        if (!$cart || !$cart->products->count() || !check_cart_quantity()) {
            return redirect()->route('front.cart');
        }

        if ($request->reserve != 'reserve' && !$cart->carrier_id && $cart->hasPhysicalProduct()) {
            return redirect()->route('front.checkout')->withErrors(['carrier_id' => 'نحوه ارسال انتخاب نشده است']);
        }

        if (!check_cart_discount()['status']) {
            return redirect()->route('front.checkout');
        }

        $gateway  = Gateway::where('key', $request->gateway)->first();
        $data     = $request->validated();

        $data['shipping_cost']      = $cart->shippingCostAmount();
        $data['price']              = $cart->finalPrice();
        $data['status']             = 'unpaid';
        $data['discount_amount']    = $cart->totalDiscount();
        $data['discount_id']        = $cart->discount_id;
        $data['weight']             = $cart->weight();
        $data['user_id']            = $user->id;

        if (option('reserve_orders_enabled')) {
            $data['reserve'] = $cart->reserved();
        }

        if ($gateway) {
            $data['gateway_id']         = $gateway->id;
        }

        if ($cart->hasPhysicalProduct() && !$cart->reserved()) {
            $carrier_result = Cart::canUseCarrier($request->carrier_id, $cart->weight(), $cart->city_id);

            if (!$carrier_result['status']) {
                return redirect()->back()->withInput()->withErrors([
                    'carrier_id' => $carrier_result['message'],
                ]);
            }
        }

        $order = Order::create($data);

        //add cart products to order
        foreach ($cart->products as $product) {

            $price = $product->prices()->find($product->pivot->price_id);

            if ($price) {
                $order->items()->create([
                    'product_id'      => $product->id,
                    'title'           => $product->title,
                    'price'           => $price->salePrice(),
                    'real_price'      => $price->regularPrice(),
                    'quantity'        => $product->pivot->quantity,
                    'discount'        => $price->discount(),
                    'price_id'        => $product->pivot->price_id,
                ]);
            }
        }

        if ($cart->send_reserved_orders) {
            $orders_id = $user->orders()->reserved()->paid()->pluck('id')->toArray();

            $order->reservedOrders()->sync($orders_id);

            $user->orders()->reserved()->paid()->update([
                'reserve'       => false,
                'main_order_id' => $order->id
            ]);
        }

        $cart->delete();

        // cancel order after $minutes
        $minutes = option('orders_cancel_time', 60);
        CancelOrder::dispatch($order)->delay(now()->addMinutes($minutes));

        event(new OrderCreated($order));

        return $this->pay($order, $request);
    }

    public function edit(Order $order)
    {
        if ($order->user_id != auth()->user()->id || !$order->isPaid() || !$order->reserved()) {
            abort(404);
        }

        $gateways  = Gateway::active()->orderBy('ordering')->get();
        $provinces = Province::detectLang()->active()->orderBy('ordering')->get();
        $carriers  = Carrier::detectLang()->active()->latest()->get();
        $wallet    = auth()->user()->getWallet();

        return view('front::user.orders.edit', compact(
            'order',
            'gateways',
            'provinces',
            'carriers',
            'wallet',
        ));
    }

    public function update(Order $order, UpdateOrderRequest $request)
    {
        if ($order->user_id != auth()->user()->id || !$order->isPaid() || !$order->reserved()) {
            abort(404);
        }

        if (!$order->carrier_id)
            return redirect()->route('front.orders.edit', ['order', $order])->withErrors(['carrier_id' => 'نحوه ارسال انتخاب نشده است']);

        $gateway = Gateway::where('key', $request->gateway)->first();
        $data    = $request->validated();

        $data['shipping_cost'] = $order->shippingCostAmount();

        if ($gateway) {
            $data['gateway_id'] = $gateway->id;
        }

        $order->update($data);

        $carrier_result = Cart::canUseCarrier($request->carrier_id, $order->weight(), $order->city_id);

        if (!$carrier_result['status']) {
            return redirect()->back()->withInput()->withErrors([
                'carrier_id' => $carrier_result['message'],
            ]);
        }

        return $this->payShippingCost($order, $request);
    }

    public function payShippingCost(Order $order, Request $request)
    {
        if ($order->shippingCostAmount() == 0) {
            return $this->shippingCostPaid($order);
        }

        $gateways = Gateway::active()->pluck('key')->toArray();

        $request->validate([
            'gateway' => 'required|in:wallet,' . implode(',', $gateways)
        ]);

        $gateway = $request->gateway;

        if ($gateway == 'wallet') {
            return $this->payShippingCostUsingWallet($order);
        }

        $gateway = $request->gateway;
        $amount  = $order->shippingCostAmount();

        try {
            $gateway_configs = get_gateway_configs($gateway);

            return Payment::via($gateway)->config($gateway_configs)->callbackUrl(route('front.orders.shipping-cost.verify', ['gateway' => $gateway]))->purchase(
                (new Invoice)->amount(intval($amount)),
                function ($driver, $transactionId) use ($order, $gateway, $amount) {
                    DB::table('transactions')->insert([
                        'status'               => false,
                        'amount'               => $amount,
                        'factorNumber'         => $order->id,
                        'mobile'               => auth()->user()->username,
                        'message'              => trans('front::messages.controller.port-transaction') . $gateway,
                        'transID'              => (string) $transactionId,
                        'token'                => (string) $transactionId,
                        'user_id'              => auth()->user()->id,
                        'transactionable_type' => Order::class,
                        'transactionable_id'   => $order->id,
                        'gateway_id'           => Gateway::where('key', $gateway)->first()->id,
                        "created_at"           => Carbon::now(),
                        "updated_at"           => Carbon::now(),
                    ]);

                    session()->put('transactionId', (string) $transactionId);
                    session()->put('amount', $amount);
                }
            )->pay()->render();
        } catch (Exception $e) {
            return redirect()
                ->route('front.orders.show', ['order' => $order])
                ->with('error', $e->getMessage())
                ->with('order_id', $order->id);
        }
    }

    public function verifyShippingCost($gateway)
    {
        $transactionId = session()->get('transactionId');
        $amount = session()->get('amount');

        $transaction = Transaction::where('status', false)->where('transID', $transactionId)->firstOrFail();

        $order = $transaction->transactionable;

        $gateway_configs = get_gateway_configs($gateway);

        try {
            $receipt = Payment::via($gateway)->config($gateway_configs);

            if ($amount) {
                $receipt = $receipt->amount(intval($amount));
            }

            $receipt = $receipt->transactionId($transactionId)->verify();

            DB::table('transactions')->where('transID', (string) $transactionId)->update([
                'status'               => 1,
                'amount'               => $order->shippingCostAmount(),
                'factorNumber'         => $order->id,
                'mobile'               => $order->mobile,
                'traceNumber'          => $receipt->getReferenceId(),
                'message'              => $transaction->message . '<br>' . trans('front::messages.controller.successful-payment') . $gateway,
                'updated_at'           => Carbon::now(),
            ]);

            return $this->shippingCostPaid($order);
        } catch (\Exception $exception) {

            DB::table('transactions')->where('transID', (string) $transactionId)->update([
                'message'              => $transaction->message . '<br>' . $exception->getMessage(),
                "updated_at"           => Carbon::now(),
            ]);

            return redirect()->route('front.orders.show', ['order' => $order])->with('error', $exception->getMessage());
        }
    }

    public function pay(Order $order, Request $request)
    {
        if ($order->price == 0) {
            return $this->orderPaid($order);
        }

        $gateways = Gateway::active()->pluck('key')->toArray();

        $request->validate([
            'gateway' => 'required|in:wallet,' . implode(',', $gateways)
        ]);

        $gateway = $request->gateway;

        if ($gateway == 'wallet') {
            return $this->payUsingWallet($order);
        }

        try {

            $gateway_configs = get_gateway_configs($gateway);

            return Payment::via($gateway)->config($gateway_configs)->callbackUrl(route('front.orders.verify', ['gateway' => $gateway]))->purchase(
                (new Invoice)->amount(intval($order->price)),
                function ($driver, $transactionId) use ($order, $gateway) {
                    DB::table('transactions')->insert([
                        'status'               => false,
                        'amount'               => $order->price,
                        'factorNumber'         => $order->id,
                        'mobile'               => auth()->user()->username,
                        'message'              => trans('front::messages.controller.port-transaction') . $gateway,
                        'transID'              => (string) $transactionId,
                        'token'                => (string) $transactionId,
                        'user_id'              => auth()->user()->id,
                        'transactionable_type' => Order::class,
                        'transactionable_id'   => $order->id,
                        'gateway_id'           => Gateway::where('key', $gateway)->first()->id,
                        "created_at"           => Carbon::now(),
                        "updated_at"           => Carbon::now(),
                    ]);

                    session()->put('transactionId', (string) $transactionId);
                    session()->put('amount', $order->price);
                }
            )->pay()->render();
        } catch (Exception $e) {
            return redirect()
                ->route('front.orders.show', ['order' => $order])
                ->with('transaction-error', $e->getMessage())
                ->with('order_id', $order->id);
        }
    }

    public function verify($gateway)
    {
        $transactionId = session()->get('transactionId');
        $amount = session()->get('amount');

        $transaction = Transaction::where('status', false)->where('transID', $transactionId)->firstOrFail();

        $order = $transaction->transactionable;

        $gateway_configs = get_gateway_configs($gateway);

        try {
            $receipt = Payment::via($gateway)->config($gateway_configs);

            if ($amount) {
                $receipt = $receipt->amount(intval($amount));
            }

            $receipt = $receipt->transactionId($transactionId)->verify();

            DB::table('transactions')->where('transID', (string) $transactionId)->update([
                'status'               => 1,
                'amount'               => $order->price,
                'factorNumber'         => $order->id,
                'mobile'               => $order->mobile,
                'traceNumber'          => $receipt->getReferenceId(),
                'message'              => $transaction->message . '<br>' . trans('front::messages.controller.successful-payment') . $gateway,
                'updated_at'           => Carbon::now(),
            ]);

            return $this->orderPaid($order);
        } catch (\Exception $exception) {

            DB::table('transactions')->where('transID', (string) $transactionId)->update([
                'message'              => $transaction->message . '<br>' . $exception->getMessage(),
                "updated_at"           => Carbon::now(),
            ]);

            return redirect()->route('front.orders.show', ['order' => $order])->with('transaction-error', $exception->getMessage());
        }
    }

    public function getPrices(Order $order, Request $request)
    {
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

        if ($request->city_id) {
            $province_id = City::find($request->city_id)->province_id;
        } else {
            $province_id = null;
        }

        $order->update([
            'province_id' => $province_id,
            'city_id'     => $request->city_id,
            'carrier_id'  => $request->carrier_id,
        ]);

        return [
            'checkout_sidebar'   => view('front::partials.order-sidebar', ['order' => $order])->render(),

            'carriers_container' => view('front::partials.carriers-container', [
                'cart'     => $order,
                'carriers' => $carriers
            ])->render(),
        ];
    }

    private function payUsingWallet(Order $order)
    {
        $wallet  = $order->user->getWallet();
        $amount  = intval($wallet->balance() - $order->price);

        if ($amount >= 0) {
            $result = $order->payUsingWallet();

            if ($result) {
                return $this->orderPaid($order);
            }
        }

        $gateway = Gateway::active()->orderBy('ordering')->first();
        $amount  = abs($amount);

        if (!$gateway) {
            return redirect()->route('front.orders.show', ['order' => $order])
                ->with('transaction-error', trans('front::messages.controller.active-port'))
                ->with('order_id', $order->id);
        }

        $history = $wallet->histories()->create([
            'type'        => 'deposit',
            'amount'      => $amount,
            'description' => trans('front::messages.controller.online-wallet-recharge'),
            'source'      => 'user',
            'status'      => 'fail',
            'order_id'    => $order->id
        ]);

        try {
            $gateway         = $gateway->key;
            $gateway_configs = get_gateway_configs($gateway);

            return Payment::via($gateway)->config($gateway_configs)->callbackUrl(route('front.wallet.verify', ['gateway' => $gateway]))->purchase(
                (new Invoice)->amount($amount),
                function ($driver, $transactionId) use ($history, $gateway, $amount) {
                    DB::table('transactions')->insert([
                        'status'               => false,
                        'amount'               => $amount,
                        'factorNumber'         => $history->id,
                        'mobile'               => auth()->user()->username,
                        'message'              => trans('front::messages.controller.port-transaction') . $gateway,
                        'transID'              => $transactionId,
                        'token'                => $transactionId,
                        'user_id'              => auth()->user()->id,
                        'transactionable_type' => WalletHistory::class,
                        'transactionable_id'   => $history->id,
                        'gateway_id'           => Gateway::where('key', $gateway)->first()->id,
                        "created_at"           => Carbon::now(),
                        "updated_at"           => Carbon::now(),
                    ]);

                    session()->put('transactionId', $transactionId);
                    session()->put('amount', $amount);
                }
            )->pay()->render();
        } catch (Exception $e) {
            return redirect()->route('front.orders.show', ['order' => $order])
                ->with('transaction-error', $e->getMessage())
                ->with('order_id', $order->id);
        }
    }

    private function payShippingCostUsingWallet(Order $order)
    {
        $wallet  = $order->user->getWallet();
        $amount  = intval($wallet->balance() - $order->shippingCostAmount());

        if ($amount >= 0) {
            $result = $order->payShippingCostUsingWallet();

            if ($result) {
                return $this->shippingCostPaid($order);
            }
        }

        $gateway = Gateway::active()->orderBy('ordering')->first();
        $amount  = abs($amount);

        if (!$gateway) {
            return redirect()->route('front.orders.show', ['order' => $order])
                ->with('error', trans('front::messages.controller.active-port'))
                ->with('order_id', $order->id);
        }

        $history = $wallet->histories()->create([
            'type'          => 'deposit',
            'amount'        => $amount,
            'description'   => trans('front::messages.controller.online-wallet-recharge'),
            'source'        => 'user',
            'status'        => 'fail',
            'order_id'      => $order->id,
            'shipping_cost' => true,
        ]);

        try {
            $gateway         = $gateway->key;
            $gateway_configs = get_gateway_configs($gateway);

            return Payment::via($gateway)->config($gateway_configs)->callbackUrl(route('front.wallet.verify', ['gateway' => $gateway]))->purchase(
                (new Invoice)->amount($amount),
                function ($driver, $transactionId) use ($history, $gateway, $amount) {
                    DB::table('transactions')->insert([
                        'status'               => false,
                        'amount'               => $amount,
                        'factorNumber'         => $history->id,
                        'mobile'               => auth()->user()->username,
                        'message'              => trans('front::messages.controller.port-transaction') . $gateway,
                        'transID'              => $transactionId,
                        'token'                => $transactionId,
                        'user_id'              => auth()->user()->id,
                        'transactionable_type' => WalletHistory::class,
                        'transactionable_id'   => $history->id,
                        'gateway_id'           => Gateway::where('key', $gateway)->first()->id,
                        "created_at"           => Carbon::now(),
                        "updated_at"           => Carbon::now(),
                    ]);

                    session()->put('transactionId', $transactionId);
                    session()->put('amount', $amount);
                }
            )->pay()->render();
        } catch (Exception $e) {
            return redirect()->route('front.orders.show', ['order' => $order])
                ->with('error', $e->getMessage())
                ->with('order_id', $order->id);
        }
    }

    private function orderPaid(Order $order)
    {
        $order->update([
            'status' => 'paid',
        ]);

        event(new OrderPaid($order));

        return redirect()->route('front.orders.show', ['order' => $order])->with('message', 'ok');
    }

    private function shippingCostPaid(Order $order)
    {
        $order->update([
            'reserve' => false,
            'price'   => $order->price + $order->shipping_cost
        ]);

        $admins = User::whereIn('level', ['admin', 'creator'])->get();
        Notification::send($admins, new NotificationsOrderPaid($order));

        return redirect()->route('front.orders.show', ['order' => $order])->with('message', 'ok');
    }
}
