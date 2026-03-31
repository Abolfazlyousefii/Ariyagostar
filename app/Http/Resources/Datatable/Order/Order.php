<?php

namespace App\Http\Resources\Datatable\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                 => $this->id,
            'order_id'           => $this->id,
            'name'               => htmlspecialchars($this->name),
            'created_at'         => jdate($this->created_at)->format('%d %B %Y'),
            'price'              => trans('messages.currency.prefix') . number_format($this->price) . trans('messages.currency.suffix'),
            'status'             => $this->status,
            'shipping_status'    => $this->shippingStatusText(),

            'links' => [
                'view'    => route('admin.orders.show', ['order' => $this]),
            ]
        ];
    }
}
