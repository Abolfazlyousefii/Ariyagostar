<?php

namespace App\Http\Requests\Back\Product;

use Illuminate\Foundation\Http\FormRequest;

class ImportProductsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'excel_file' => 'required|file|mimes:xlsx,xls,csv,txt|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'excel_file.required' => 'لطفا فایل وارد کنید.',
            'excel_file.file' => 'فایل انتخاب شده معتبر نیست.',
            'excel_file.mimes' => 'فرمت فایل باید xlsx، xls یا csv باشد.',
            'excel_file.max' => 'حجم فایل باید کمتر از 10 مگابایت باشد.',
        ];
    }
}
