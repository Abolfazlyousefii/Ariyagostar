<?php

namespace App\Http\Requests\Api\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserAddressRequest extends FormRequest
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
            'province_id'    => 'required|exists:provinces,id',
            'city_id'        => ['required', Rule::exists('cities', 'id')->where('province_id', $this->input('province_id'))],
            'postal_code'    => 'required|numeric|digits:10',
            'address'        => 'required|string|max:300',
        ];
    }
}
