<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Category\CategoryCollection;
use App\Http\Resources\Api\V1\Product\ProductCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('category_id')
            ->where('type', 'productcat')
            ->orderBy('ordering')
            ->select('id', 'title', 'slug', 'image', 'category_id')
            ->get();

        return $this->respondWithResourceCollection(new CategoryCollection($categories));
    }

    public function filter(Category $category)
    {
        //todo later changethis
        return $category->getFilter()->related;
    }
}
