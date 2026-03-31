<?php

namespace App\Http\Requests\Back\Discount;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'                 => 'required',
            'code'                  => 'required_if:method,code,carrier',
            'method'                => 'required',
            'start_date'            => 'nullable',
            'end_date'              => 'required',
            'type'                  => 'required_if:method,code,direct|in:amount,percent',
            'price'                 => 'required_if:type,amount|numeric|nullable',
            'percent'               => 'required_if:type,percent|numeric|min:0|max:100|nullable',
            'include_categories'    => 'required_if:include_type,category',
            'include_products'      => 'required_if:include_type,product',
            'exclude_categories'    => 'required_if:exclude_type,category',
            'exclude_products'      => 'required_if:exclude_type,product',
            'users'                 => 'nullable|exists:users,id',
            'discount_ceiling'      => 'nullable|numeric',
            'least_price'           => 'nullable|numeric',
            'least_products_count'  => 'nullable|integer',
            'description'           => 'nullable|string',
            'only_first_purchase'   => 'boolean',
            'not_discount_products' => 'boolean',
            'published'             => 'boolean',
            'quantity'              => 'nullable|integer',
            'quantity_per_user'     => 'nullable|integer',
            'include_type'          => 'in:all,product,category',
            'exclude_type'          => 'in:none,product,category'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'only_first_purchase'   => $this->has('only_first_purchase'),
            'not_discount_products' => $this->has('not_discount_products'),
            'published'             => $this->has('published'),
        ]);
    }
}
