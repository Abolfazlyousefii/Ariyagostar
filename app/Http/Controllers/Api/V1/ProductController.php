<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Product\StoreCommentRequest;
use App\Http\Resources\Api\V1\Comment\CommentCollection;
use App\Http\Resources\Api\V1\Product\ProductCollection;
use App\Http\Resources\Api\V1\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->per_page ?: 20;

        $products = Product::with('category')
            ->published()
            ->orderByStock()
            ->apiFilter()
            ->latest()
            ->paginate($per_page);

        return $this->respondWithResourceCollection(new ProductCollection($products));
    }

    public function show(Product $product)
    {
        if (!$product->isPublished()) {
            abort(404);
        }

        return $this->respondWithResource(new ProductResource($product));
    }

    public function comments(Product $product, Request $request)
    {
        $per_page = $request->per_page ?: 20;

        $comments = $product->comments()
            ->whereNull('comment_id')
            ->accepted()
            ->latest()
            ->paginate($per_page);

        return $this->respondWithResourceCollection(new CommentCollection($comments));
    }

    public function relatedProducts(Product $product, Request $request)
    {
        $per_page = $request->per_page ?: 20;

        $products = $product->relatedProducts()->with('category')
            ->published()
            ->orderByStock()
            ->latest()
            ->paginate($per_page);

        return $this->respondWithResourceCollection(new ProductCollection($products));
    }

    public function storeComment(Product $product, StoreCommentRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = $request->user()->id;

        if ($request->user()->isAdmin()) {
            $data['status'] = 'accepted';
        }

        $product->comments()->create($data);

        return $this->respondCreated(['message' => 'دیدگاه با موفقیت ثبت شد']);
    }
}
