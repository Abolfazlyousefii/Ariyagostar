<?php

namespace App\Http\Requests\Back\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductImportPreviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'excel_file' => 'required|file|mimes:xlsx,xls,csv,txt',
            'duplicate_strategy' => 'required|in:skip,update,new_only',
            'create_missing_taxonomy' => 'nullable|in:0,1',
            'import_images' => 'nullable|in:0,1',
        ];
    }
}
