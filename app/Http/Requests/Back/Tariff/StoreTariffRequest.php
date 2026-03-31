<?php

namespace App\Http\Requests\Back\Tariff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTariffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'carrier_id'     => 'required|exists:carriers,id',
            'type'           => 'required|in:within_province,extra_province',
            'shipping_cost'  => 'required|numeric',
            'max_weight'     => [
                'required', 'numeric', Rule::unique('tariffs')->where(function ($query) {
                    return $query->where('carrier_id', $this->carrier_id)->where('type', $this->type);
                })
            ],
        ];
    }

    public function messages()
    {
        return [
            'max_weight.unique' => 'برای این وزن قبلا هزینه پستی وارد شده است'
        ];
    }
}
