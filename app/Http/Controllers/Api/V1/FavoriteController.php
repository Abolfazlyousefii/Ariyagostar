<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Product\ProductCollection;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->per_page ?: 20;

        $products = $request->user()
            ->favoriteProducts()
            ->published()
            ->latest()
            ->paginate($per_page);

        return $this->respondWithResourceCollection(new ProductCollection($products));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $request->user()->favorites()->firstOrCreate([
            'product_id' => $request->product_id
        ]);

        return $this->respondSuccess('با موفقیت به لیست علاقمندی ها اضافه شد');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $request->user()
            ->favorites()
            ->where('product_id', $request->product_id)
            ->delete();

        return $this->respondSuccess('با موفقیت از لیست علاقمندی ها حذف شد');
    }
}
