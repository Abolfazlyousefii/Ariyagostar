<?php

namespace App\Http\Resources\Api\V1\Cart;

use App\Http\Resources\Api\V1\Price\PriceResource;
use App\Models\Price;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                     => $this->id,
            'id'                     => $this->id,
            'cart_id'                => Crypt::encryptString($this->id),
            'discount_id'            => $this->discount_id,
            'total_discount'         => $this->totalDiscount(),
            'shipping_cost'          => $this->shippingCost(),
            'shipping_cost_amount'   => $this->shippingCostAmount(),
            'final_price'            => $this->finalPrice(),
            'weight'                 => $this->weight(),
            'products'               => $this->productsCollection($this->products)
        ];
    }

    private function productsCollection($products)
    {
        return $products->map(function ($product) {
            return [
                'id'                 => $product->id,
                'title'              => $product->title,
                'title_en'           => $product->title_en,
                'category_id'        => $product->category_id,
                'slug'               => $product->slug,
                'image'              => $product->image ? asset($product->image) : null,
                'unit'               => $product->unit,
                'special'            => $product->isSpecial(),
                'short_description'  => $product->short_description,
                'quantity'           => $product->pivot->quantity,
                'price'              => new PriceResource(Price::find($product->pivot->price_id))
            ];
        });
    }
}
