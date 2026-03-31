<?php

namespace App\Http\Requests\Back\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'               => 'required|regex:/(09)[0-9]{9}/|digits:11',
            'first_name'             => 'required',
            'last_name'              => 'required',
            'province_id'            => 'required|exists:provinces,id',
            'city_id'                => 'required|exists:cities,id',
            'postal_code'            => 'nullable|string',
            'address'                => 'nullable|string',
            'products'               => 'required|array',
            'products.*.id'          => 'required|exists:products,id',
            'products.*.price_id'    => 'required|exists:prices,id',
            'products.*.quantity'    => 'required|numeric',
            'discount_amount'        => 'nullable|numeric',
            'carrier_id'             => 'nullable|exists:carriers,id',
            'shipping_cost'          => 'nullable|numeric',
            'shipping_status'        => 'required|in:pending,wating,sent,canceled',
            'description'            => 'nullable|string',
        ];
    }
}
