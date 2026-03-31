<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Order\OrderCollection;
use App\Http\Resources\Api\V1\Order\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->per_page ?: 20;
        $orders   = $request->user()->orders()->latest()->paginate($per_page);

        return $this->respondWithResourceCollection(new OrderCollection($orders));
    }

    public function show(Order $order)
    {
        return $this->respondWithResource(new OrderResource($order));
    }
}
