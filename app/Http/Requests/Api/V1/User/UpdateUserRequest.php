<?php

namespace App\Http\Requests\Api\V1\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'first_name'     => 'required|string',
            'last_name'      => 'required|string',
            'username'       => 'required|string|regex:/(09)[0-9]{9}/|digits:11|unique:users,username,' . auth()->user()->id,
            'email'          => 'string|email|max:191|unique:users,email,' . auth()->user()->id . '|nullable',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'لطفا یک شماره موبایل معتبر وارد کنید',
            'username.string'   => 'لطفا یک شماره موبایل معتبر وارد کنید',
            'username.regex'    => 'لطفا یک شماره موبایل معتبر وارد کنید',
            'username.digits'   => 'لطفا یک شماره موبایل معتبر وارد کنید',
            'username.unique'   => 'شماره موبایل وارد شده تکراری است',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'username'   => convertPersianToEnglish($this->input('username'))
        ]);
    }
}
