<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Sms;
use App\Models\Viewer;
use App\Traits\OrderStatisticsTrait;
use App\Traits\UserStatisticsTrait;
use App\Traits\ViewStatisticsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    use OrderStatisticsTrait, UserStatisticsTrait, ViewStatisticsTrait;

    public function viewsList()
    {
        $this->authorize('statistics.viewsList');

        $views = Viewer::latest();

        if (auth()->user()->level != 'creator') {
            $views = $views->whereNull('user_id')->orWhere(function ($query) {
                $query->whereHas('user', function ($q1) {
                    $q1->where('level', '!=', 'creator');
                });
            });
        }

        $views = $views->paginate(20);

        return view('back.statistics.views.viewsList', compact('views'));
    }

    public function views()
    {
        $this->authorize('statistics.views');

        return view('back.statistics.views.index');
    }

    public function viewers()
    {
        $this->authorize('statistics.viewers');

        $viewers = Viewer::latest()->whereDate('created_at', now())->get()->unique('user_id');

        return view('back.statistics.viewers.viewers', compact('viewers'));
    }

    public function orders()
    {
        $this->authorize('statistics.orders');

        return view('back.statistics.orders.index');
    }

    public function users()
    {
        $this->authorize('statistics.users');

        return view('back.statistics.users.index');
    }

    public function smsLog()
    {
        $this->authorize('statistics.sms');

        $sms = Sms::latest()->paginate(20);

        return view('back.statistics.sms.sms-log', compact('sms'));
    }

    public function bestSellingProducts(Request $request)
    {
        $this->authorize('statistics.bestSellingProducts');

        $brands     = Brand::orderBy('name')->select('id', 'name')->get();
        $categories = Category::detectLang()->where('type', 'productcat')->orderBy('ordering')->get();

        $query = OrderItem::whereHas('order', function ($q) {
            $q->paid();
        })->whereHas('product', function ($q) {
            $q->filter(request());
        });

        if ($request->report_type == 'quantity') {
            $query->select('product_id', DB::raw('SUM(quantity) as total_sale, max(title) as title'));
        } else {
            $query->select('product_id', DB::raw('SUM(quantity * price) as total_sale, max(title) as title'));
        }

        $order_items = $query->groupBy('product_id')
            ->orderBy('total_sale', 'desc')
            ->with('product:id,title,slug,image')
            ->paginate(20)->withQueryString();

        return view('back.statistics.products.bestSellingProducts', compact(
            'order_items',
            'brands',
            'categories'
        ));
    }

    public function cityReport(Request $request)
    {
        $this->authorize('statistics.cityReport');

        $brands     = Brand::orderBy('name')->select('id', 'name')->get();
        $categories = Category::detectLang()->where('type', 'productcat')->orderBy('ordering')->get();

        $query = Order::paid()->whereHas('products', function ($q) {
            $q->filter(request());
        });

        if ($request->report_mode == 'city') {
            $query->groupBy('city_id')->select('city_id', DB::raw('max(city_id) as ref_id'));
        } else {
            $query->groupBy('province_id')->select('province_id',  DB::raw('max(province_id) as ref_id'));
        }

        if ($request->report_type == 'quantity') {
            $query->addSelect(DB::raw('count(*) as total_sale'));
        } else {
            $query->addSelect(DB::raw('SUM(price) as total_sale'));
        }

        $orders = $query->orderBy('total_sale', 'desc')->paginate(20)->withQueryString();

        return view('back.statistics.products.cityReport', compact(
            'orders',
            'brands',
            'categories'
        ));
    }

    public function stockReport(Request $request)
    {
        $this->authorize('statistics.stockReport');

        $brands     = Brand::orderBy('name')->select('id', 'name')->get();
        $categories = Category::detectLang()->where('type', 'productcat')->orderBy('ordering')->get();
        $products   = Product::with('prices')->datatableFilter($this->nestInputs($request))->paginate($request->per_page ?? 20)->withQueryString();

        return view('back.statistics.products.stockReport', compact(
            'products',
            'brands',
            'categories'
        ));
    }

    protected function nestInputs(Request $request)
    {
        $nestedInputs = ['query' => $request->all()];

        // Replace the request input with nested input
        return $request->merge($nestedInputs);
    }

    public function userOrders(Request $request)
    {
        $this->authorize('statistics.userOrders');

        $query = Order::whereHas('user')->paid();

        if ($request->report_type == 'quantity') {
            $query->select('user_id', DB::raw('count(*) as total_sale'))->orderBy('total_sale', 'desc');
        } else {
            $query->select('user_id', DB::raw('SUM(price) as total_sale'))->orderBy('total_sale', 'desc');
        }

        $orders = $query->groupBy('user_id')
            ->with('user:id,first_name,last_name')
            ->paginate(20)->withQueryString();

        return view('back.statistics.users.userOrders', compact(
            'orders',
        ));
    }
}
