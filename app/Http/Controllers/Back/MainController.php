<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MainController extends Controller
{
    public function index()
    {
        $users_count = Cache::rememberForever('admin.users_count', function () {
            return User::where('level', '!=', 'creator')->count();
        });

        $products_count = Cache::rememberForever('admin.products_count', function () {
            return Product::count();
        });

        $orders_count = Cache::rememberForever('admin.orders_count', function () {
            return Order::where("status", "paid")->count();
        });

        $total_sell = Cache::rememberForever('admin.total_sell', function () {
            return Order::where('status', 'paid')->sum('price');
        });

        return view('back.index', compact(
            'users_count',
            'products_count',
            'orders_count',
            'total_sell'
        ));
    }

    public function get_tags(Request $request)
    {
        $tags = Tag::detectLang()->where('name', 'like', '%' . $request->term . '%')
            ->latest()
            ->take(5)
            ->pluck('name')
            ->toArray();

        return response()->json($tags);
    }

    public function getLabels(Request $request)
    {
        $labels = Label::detectLang()->where('title', 'like', '%' . $request->term . '%')
            ->latest()
            ->take(5)
            ->pluck('title')
            ->toArray();

        return response()->json($labels);
    }

    public function login()
    {
        return view('back.auth.login');
    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications()->paginate(15);

        auth()->user()->unreadNotifications->markAsRead();

        return view('back.notifications', compact('notifications'));
    }

    public function fileManager()
    {
        $this->authorize('file-manager');

        return view('back.file-manager');
    }

    public function fileManagerIframe()
    {
        $this->authorize('file-manager');

        return view('back.file-manager-iframe');
    }
}
