<?php

namespace App\Http\Requests\Back\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductImportRunRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'import_token' => 'required|string',
            'duplicate_strategy' => 'required|in:skip,update,new_only',
            'create_missing_taxonomy' => 'nullable|in:0,1',
            'import_images' => 'nullable|in:0,1',
            'mapping' => 'required|array',
            'mapping.title' => 'required|string',
            'mapping.slug' => 'nullable|string',
            'mapping.short_description' => 'nullable|string',
            'mapping.description' => 'nullable|string',
            'mapping.price' => 'required|string',
            'mapping.discount_price' => 'nullable|string',
            'mapping.sku' => 'nullable|string',
            'mapping.stock' => 'nullable|string',
            'mapping.category' => 'nullable|string',
            'mapping.subcategory' => 'nullable|string',
            'mapping.brand' => 'nullable|string',
            'mapping.images' => 'nullable|string',
            'mapping.published' => 'nullable|string',
        ];
    }
}
