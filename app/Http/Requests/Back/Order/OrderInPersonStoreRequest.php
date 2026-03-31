<?php

namespace App\Http\Requests\Back\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderInPersonStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'            => 'string|nullable|regex:/(09)[0-9]{9}/|digits:11',
            'first_name'          => 'string|nullable',
            'last_name'           => 'string|nullable',
            'products'            => 'required|array',
            'products.*.id'       => 'required|exists:products,id',
            'products.*.price_id' => 'required|exists:prices,id',
            'products.*.quantity' => 'required|numeric',
            'description'         => 'nullable|string',
        ];
    }
}
