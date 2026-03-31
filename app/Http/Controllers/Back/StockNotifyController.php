<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\StockNotify;
use Illuminate\Http\Request;

class StockNotifyController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:products.stock-notify');
    }

    public function index()
    {
        $stocknotifies = StockNotify::latest()->paginate(15);

        return view('back.stocknotifies.index', compact('stocknotifies'));
    }

    public function show(StockNotify $stock_notify)
    {
        return view('back.stocknotifies.show', compact('stock_notify'))->render();
    }

    public function destroy(StockNotify $stock_notify)
    {
        $stock_notify->delete();

        return response('success');
    }
}
