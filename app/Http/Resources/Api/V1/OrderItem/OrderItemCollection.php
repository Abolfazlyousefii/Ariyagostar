<?php

namespace App\Http\Resources\Api\V1\OrderItem;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderItemCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {


            return [
                'id'              => $item->id,
                'title'           => $item->product ? $item->product->title : $item->title,
                'price'           => $item->price,
                'real_price'      => $item->real_price,
                'quantity'        => $item->quantity,
                'discount'        => $item->discount,
                'product'         => $this->getProduct($item->product),
            ];
        });
    }

    private function getProduct($product)
    {
        if ($product) {
            return [
                'id'               => $product->id,
                'title'            => $product->title,
                'title_en'         => $product->title_en,
                'price'            => $product->getLowestPrice(true),
                'regular_price'    => $product->getLowestDiscount(true),
                'sale_price'       => $product->getLowestPrice(true),
                'slug'             => $product->slug,
                'image'            => $product->image ? asset($product->image) : null,
                'category'         => $product->category ? $product->category->title : null,
                'published_date'   => $product->published_at ?: $product->created_at,
                'is_available'     => $product->addableToCart()
            ];
        }

        return null;
    }
}
