<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Rules\NotSpecialChar;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255', new NotSpecialChar()],
            'last_name'  => ['required', 'string', 'max:255', new NotSpecialChar()],
            'username'   => ['required', 'string', 'regex:/(09)[0-9]{9}/', 'digits:11', 'unique:users'],
            'password'   => ['required', 'string', 'min:8'],
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
