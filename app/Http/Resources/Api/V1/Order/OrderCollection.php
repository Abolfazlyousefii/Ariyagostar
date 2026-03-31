<?php

namespace App\Http\Resources\Api\V1\Order;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($order) {
            return [
                'id'                => $order->id,
                'name'              => $order->name,
                'address'           => $order->address,
                'shipping_cost'     => $order->shipping_cost,
                'price'             => $order->price,
                'shipping_status'   => $order->shipping_status,
                'created_at'        => $order->created_at,
                'created_at_jalali' => jdate($order->created_at)->format('Y-m-d'),
                'discount_amount'   => $order->discount_amount,
            ];
        });
    }
}
