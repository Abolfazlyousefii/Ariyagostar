<?php

namespace App\Http\Controllers\Back;

use App\Models\User;
use App\Models\Order;
use App\Models\Price;
use App\Models\Carrier;
use App\Models\Product;
use App\Models\Province;
use App\Models\SizeType;
use App\Events\OrderCreated;
use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\Order\OrderInPersonStoreRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\Sms\TrackingCodeSms;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Back\Order\OrderStoreRequest;
use App\Http\Resources\Api\V1\Product\ProductResource;
use App\Http\Resources\Datatable\Order\OrderCollection;
use App\Models\Sms;
use App\Services\Sms\SmsService;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Order::class, 'order');
    }

    public function index()
    {
        $sizeTypes = SizeType::latest()->get();

        return view('back.orders.index', compact('sizeTypes'));
    }

    public function apiIndex(Request $request)
    {
        $this->authorize('orders.index');

        $orders = Order::filter($request);

        $orders = datatable($request, $orders);

        return new OrderCollection($orders);
    }

    public function show(Order $order)
    {
        if ($order->in_person) {
            return view('back.orders.inPersonShow', compact('order'));
        }

        return view('back.orders.show', compact('order'));
    }

    public function create()
    {
        $provinces = Province::detectLang()->orderBy('ordering')->get();
        $carriers  = Carrier::active()->get();

        return view('back.orders.create', compact('provinces', 'carriers'));
    }

    public function store(OrderStoreRequest $request)
    {
        $user = User::firstOrCreate(
            [
                'username' => $request->username
            ],
            [
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'password'   => bcrypt(rand(11111111, 999999999) . $request->username)
            ]
        );

        $order_price = 0;

        foreach ($request->products as $requestProduct) {
            $product = Product::find($requestProduct['id']);
            $price   = $product->prices()->find($requestProduct['price_id']);

            $orderItems[] = [
                'product_id'      => $product->id,
                'title'           => $product->title,
                'price'           => $price->discountPrice(),
                'real_price'      => $price->tomanPrice(),
                'quantity'        => $requestProduct['quantity'],
                'discount'        => $price->discount,
                'price_id'        => $price->id,
            ];

            $order_price += $price->discountPrice() * $requestProduct['quantity'];
        }

        $order_price += $request->shipping_cost;
        $order_price -= $request->discount_amount;

        $order = Order::create([
            'user_id'           => $user->id,
            'name'              => $request->first_name . ' ' . $request->last_name,
            'mobile'            => $request->username,
            'province_id'       => $request->province_id,
            'city_id'           => $request->city_id,
            'postal_code'       => $request->postal_code,
            'carrier_id'        => $request->carrier_id,
            'address'           => $request->address,
            'description'       => $request->description,
            'shipping_cost'     => $request->shipping_cost ?: 0,
            'status'            => 'paid',
            'shipping_status'   => $request->shipping_status,
            'discount_amount'   => $request->discount_amount,
            'price'             => $order_price
        ]);

        $order->items()->createMany($orderItems);

        event(new OrderCreated($order));

        return response('success');
    }

    public function inPersonCreate()
    {
        $this->authorize('orders.inPersonCreate');

        return view('back.orders.inPersonCreate');
    }

    public function inPersonStore(OrderInPersonStoreRequest $request)
    {
        $this->authorize('orders.inPersonCreate');

        $order_price = 0;
        $discount_amount = 0;

        foreach ($request->products as $requestProduct) {
            $product = Product::find($requestProduct['id']);
            $price   = $product->prices()->find($requestProduct['price_id']);

            $orderItems[] = [
                'product_id'    => $product->id,
                'title'         => $product->title,
                'price'         => $requestProduct['price'] - $requestProduct['discount'],
                'real_price'    => $requestProduct['price'],
                'quantity'      => $requestProduct['quantity'],
                'discount'      => $requestProduct['discount'],
                'discount_type' => 'fixed',
                'price_id'      => $price->id,
            ];

            $discount_amount += $requestProduct['discount'];
            $order_price += ($requestProduct['price'] - $requestProduct['discount']) * $requestProduct['quantity'];
        }

        if ($request->caculate_tax) {
            $order_price += $order_price * (intval(option('in_person_factor_tax')) / 100);
        }

        $fullname = $request->first_name . ' ' . $request->last_name;
        $user_id = null;

        if ($request->first_name && $request->last_name && $request->username) {
            $user = User::firstOrCreate(
                [
                    'username' => $request->username
                ],
                [
                    'first_name' => $request->first_name,
                    'last_name'  => $request->last_name,
                    'password'   => bcrypt(rand(11111111, 999999999) . $request->username)
                ]
            );

            $user_id = $user->id;
        }

        $order = Order::create([
            'name'            => $fullname,
            'mobile'          => $request->username,
            'description'     => $request->description,
            'shipping_cost'   => 0,
            'status'          => 'paid',
            'discount_amount' => $discount_amount,
            'discount_type'   => 'fixed',
            'price'           => $order_price,
            'in_person'       => true,
            'tax'             => $request->caculate_tax ? option('in_person_factor_tax') : 0,
            'shipping_status' => 'sent',
            'user_id'         => $user_id
        ]);

        $order->items()->createMany($orderItems);

        event(new OrderCreated($order));

        if ($fullname && $request->username && option('user_sms_on_in_person_order', 'off') == 'on') {

            $data = [
                'mobile' => $request->username,
                'data'   => [
                    'order_id' => $order->id,
                    'fullname' => $fullname,
                ],
                'type' => Sms::TYPES['IN_PERSON_ORDER'],
            ];

            $smsService = new SmsService($data['mobile'], $data['data'], $data['type'], null);
            $smsService->sendSms();
        }

        return response()->json([
            'print' => route('admin.orders.print', ['order' => $order]),
            'edit'  => route('admin.orders.inPersonEdit', ['order' => $order]),
            'new'   => route('admin.orders.inPersonCreate')
        ]);
    }

    public function inPersonEdit(Order $order)
    {
        $this->authorize('orders.inPersonCreate');

        return view('back.orders.inPersonEdit', compact('order'));
    }

    public function inPersonUpdate(OrderInPersonStoreRequest $request, Order $order)
    {
        $this->authorize('orders.inPersonCreate');

        $order_price = 0;
        $discount_amount = 0;

        foreach ($order->items()->get() as $item) {
            $price   = $item->get_price;
            $product = $price->product;

            if ($price) {
                $price->update([
                    'stock' => $price->stock + $item->quantity
                ]);
            }

            $item->delete();
        }

        foreach ($request->products as $requestProduct) {
            $product = Product::find($requestProduct['id']);
            $price   = $product->prices()->find($requestProduct['price_id']);

            $orderItems[] = [
                'product_id'    => $product->id,
                'title'         => $product->title,
                'price'         => $requestProduct['price'] - $requestProduct['discount'],
                'real_price'    => $requestProduct['price'],
                'quantity'      => $requestProduct['quantity'],
                'discount'      => $requestProduct['discount'],
                'discount_type' => 'fixed',
                'price_id'      => $price->id,
            ];

            $discount_amount += $requestProduct['discount'];
            $order_price += ($requestProduct['price'] - $requestProduct['discount']) * $requestProduct['quantity'];
        }

        if ($request->caculate_tax) {
            $order_price += $order_price * (intval(option('in_person_factor_tax')) / 100);
        }

        $order->update([
            'name'            => $request->name,
            'mobile'          => $request->mobile,
            'description'     => $request->description,
            'discount_amount' => $discount_amount,
            'price'           => $order_price,
            'tax'             => $request->caculate_tax ? option('in_person_factor_tax') : 0,
        ]);

        $order->items()->createMany($orderItems);

        event(new OrderCreated($order));

        return response()->json([
            'print' => route('admin.orders.print', ['order' => $order]),
            'edit'  => route('admin.orders.inPersonEdit', ['order' => $order]),
            'new'   => route('admin.orders.inPersonCreate')
        ]);
    }

    public function destroy(Order $order)
    {
        foreach ($order->items()->get() as $item) {
            $price = $item->get_price;

            if ($order->isInPerson() && $price) {
                $price->update([
                    'stock' => $price->stock + $item->quantity
                ]);
            }

            $item->delete();
        }

        $order->transactions()->delete();

        $order->delete();
        toastr()->success('سفارش با موفقیت حذف شد.');

        return redirect()->route('admin.orders.index');
    }

    public function multipleDestroy(Request $request)
    {
        $this->authorize('orders.delete');

        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:orders,id',
        ]);

        foreach ($request->ids as $id) {
            $order = Order::find($id);
            $this->destroy($order);
        }

        return response('success');
    }

    public function printAllShippingForms(Request $request)
    {
        $this->authorize('orders.view');

        foreach ($request->ids as $id) {
            $orders = Order::paid()->whereIn('id', $request->ids)->get();
        }

        return view('back.orders.print-all-shipping-forms', compact('orders'));
    }

    public function printAllShippingFormsMin(Request $request)
    {
        $this->authorize('orders.view');

        foreach ($request->ids as $id) {
            $orders = Order::paid()->whereIn('id', $request->ids)->get();
        }

        return view('back.orders.print-all-shipping-form-min', compact('orders'));
    }

    public function printAll(Request $request)
    {
        $this->authorize('orders.view');

        foreach ($request->ids as $id) {
            $orders = Order::paid()->whereIn('id', $request->ids)->get();
        }

        return view('back.orders.print-all', compact('orders'));
    }

    public function shipping_status(Order $order, Request $request)
    {
        $this->authorize('orders.update');

        $this->validate($request, [
            'status' => 'required',
        ]);

        $order->update([
            'shipping_status' => $request->status
        ]);

        $order->reservedOrders()->update([
            'shipping_status' => $request->status
        ]);

        return response('success');
    }

    public function tracking_code(Order $order, Request $request)
    {
        $this->authorize('orders.update');

        $order->update([
            'tracking_code' => $request->tracking_code ?? null
        ]);

        if (option('tracking_code_sms') == 'on') {
            Notification::send($order->user, new TrackingCodeSms($order));
        }

        return response('success');
    }

    public function shippingsStatus(Request $request)
    {
        $this->authorize('orders.update');

        $request->validate([
            'status' => 'required',
        ]);

        $orders = Order::whereIn('id', $request->ids)->get();

        foreach ($orders as $order) {
            if (!$order->isPaid()) {
                throw ValidationException::withMessages(['id' => 'سفارش شماره ' . $order->id . 'پرداخت نشده است ']);
            }

            if ($order->reserved()) {
                throw ValidationException::withMessages(['id' => 'سفارش شماره ' . $order->id . ' رزرو شده است ']);
            }
        }

        foreach ($orders as $order) {
            $order->update([
                'shipping_status' => $request->status
            ]);

            $order->reservedOrders()->update([
                'shipping_status' => $request->status
            ]);
        }

        return response('success');
    }

    public function notCompleted()
    {
        $this->authorize('orders.index');

        $prices = Price::whereHas('orderItems', function ($q) {
            $q->whereHas('order', function ($q2) {
                $q2->notCompleted();
            })->whereHas('product', function ($q3) {
                $q3->physical();
            });
        })->paginate(20);

        return view('back.orders.not-completed', compact('prices'));
    }

    public function print(Order $order)
    {
        $this->authorize('orders.view');

        if ($order->in_person) {
            return view('back.orders.partials.in-person-print', compact('order'));
        }

        return view('back.orders.print', compact('order'));
    }

    public function shippingForm(Order $order)
    {
        $this->authorize('orders.view');

        return view('back.orders.shipping-form', compact('order'));
    }
    public function shippingFormMin(Order $order)
    {
        $this->authorize('orders.view');

        return view('back.orders.shipping-form-min', compact('order'));
    }

    public function export(Request $request)
    {
        $this->authorize('orders.export');

        $orders = Order::filter($request)->get();

        switch ($request->export_type) {
            case 'excel': {
                    return $this->exportExcel($orders, $request);
                    break;
                }
            default: {
                    return $this->exportPrint($orders, $request);
                }
        }
    }

    public function userInfo(Request $request)
    {
        $this->authorize('orders.create');

        $request->validate([
            'input' => 'required|in:username,first_name,last_name',
        ]);

        if (!$request->term) {
            return;
        }

        $input = $request->input('input');
        $term  = $request->input('term');

        switch ($input) {
            case "username": {
                    $users = User::with('address')
                        ->where('username', 'like', "%$term%")
                        ->latest()->take(10)
                        ->get();
                    break;
                }
            case "first_name":
            case "last_name": {
                    $users = User::with('address')
                        ->where('first_name', 'like', "%$term%")
                        ->orWhere('last_name', 'like', "%$term%")
                        ->latest()->take(10)
                        ->get();
                    break;
                }
        }

        return response()->json($users);
    }

    public function productsList(Request $request)
    {
        $this->authorize('orders.create');

        $term = $request->term;

        if (!$term) {
            return;
        }

        $products = Product::with('prices')
            ->where(function ($query) use ($term) {
                $query->where('title', 'like', "%$term%")->orWhere('title_en', 'like', "%$term%");
            })
            ->orWhereHas('prices', function ($query) use ($term) {
                $query->where('id', str_replace('p-', '', $term))->orWhere('id', str_replace('P-', '', $term));
            })
            ->orderByStock()
            ->latest()
            ->take(10)
            ->get();

        return ProductResource::collection($products);
    }

    private function exportExcel($orders)
    {
        return Excel::download(new OrdersExport($orders), 'orders.xlsx');
    }
}
