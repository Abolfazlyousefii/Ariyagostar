<?php

namespace App\Http\Resources\Api\V1\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductTorobCollection extends ResourceCollection
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
            $instock = $product->addableToCart();

            return [
                'product_id'   => $product->id,
                'page_url'     => $product->link(),
                'price'        => $instock ? $product->getLowestPrice(true, true) : 0,
                'availability' => $instock ? 'instock' : false,
                'old_price'    => $instock ? ($product->getLowestDiscount(true, true) ?? $product->getLowestPrice(true, true)) : 0,
            ];
        });
    }
}
