<?php

namespace App\Http\Resources\Api\V1\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($product) {
            return [
                'id'               => $product->id,
                'title'            => $product->title,
                'title_en'         => $product->title_en,
                'type'             => $product->type,
                'price'            => $product->getLowestPrice(true),
                'regular_price'    => $product->getLowestDiscount(true),
                'sale_price'       => $product->getLowestPrice(true),
                'slug'             => $product->slug,
                'image'            => $product->image ? asset($product->image) : null,
                'special'          => $product->isSpecial(),
                'category'         => $product->category ? $product->category->title : null,
                'published_date'   => $product->published_at ?: $product->created_at,
                'is_available'     => $product->addableToCart()
            ];
        });
    }
}
