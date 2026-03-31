<?php

namespace Themes\DefaultTheme\src\Requests;

use App\Models\Gateway;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
        $gateways = Gateway::active()->pluck('key')->toArray();

        $rules = [
            'name'        => 'required|string',
            'mobile'      => 'required|string|regex:/(09)[0-9]{9}/|digits:11',
            'gateway'     => 'required|in:wallet,' . implode(',', $gateways),
            'description' => 'nullable|string|max:1000',
            'province_id' => 'required|exists:provinces,id',
            'city_id'     => 'required|exists:cities,id',
            'postal_code' => 'nullable|numeric|digits:10',
            'address'     => 'required|string|max:300',
            'carrier_id'  => 'required|exists:carriers,id'
        ];

        return $rules;
    }
}
