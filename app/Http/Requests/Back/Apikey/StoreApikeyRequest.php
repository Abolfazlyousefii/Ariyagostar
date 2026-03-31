<?php

namespace App\Http\Requests\Back\Apikey;

use Illuminate\Foundation\Http\FormRequest;

class StoreApikeyRequest extends FormRequest
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
            'key'         => 'required|string|unique:apikeys,key',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active'  => $this->has('is_active'),
        ]);
    }
}
