<?php

namespace App\Http\Resources\Api\V1\Price;

use App\Http\Resources\Api\V1\Attribute\AttributeCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
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
            'id'             => $this->id,
            'price'          => $this->salePrice(),
            'regular_price'  => $this->regularPrice(),
            'sale_price'     => $this->salePrice(),
            'discount'       => $this->discount,
            'discount_price' => $this->discountPrice(),
            'stock'          => $this->stock,
            'cart_max'       => $this->cart_max ? min($this->cart_max, $this->stock) : $this->stock,
            'cart_min'       => $this->cart_min,
            'attributes'     => new AttributeCollection($this->get_attributes)
        ];
    }
}
