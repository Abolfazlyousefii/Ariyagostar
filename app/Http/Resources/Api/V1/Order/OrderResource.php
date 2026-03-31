<?php

namespace App\Http\Resources\Api\V1\Order;

use App\Http\Resources\Api\V1\OrderItem\OrderItemCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'                    => $this->id,
            'name'                  => $this->name,
            'mobile'                => $this->mobile,
            'province'              => $this->province ? $this->province->name : null,
            'city'                  => $this->city ? $this->city->name : null,
            'postal_code'           => $this->postal_code,
            'address'               => $this->address,
            'description'           => $this->description,
            'shipping_cost'         => $this->shipping_cost,
            'price'                 => $this->price,
            'status'                => $this->status,
            'status_text'           => $this->statusText(),
            'shipping_status'       => $this->shipping_status,
            'shipping_status_text'  => $this->shippingStatusText(),
            'created_at'            => $this->created_at,
            'created_at_jalali'     => jdate($this->created_at)->format('Y-m-d'),
            'discount_amount'       => $this->discount_amount,
            'items'                 => new OrderItemCollection($this->items)
        ];
    }
}
