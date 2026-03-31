<?php

namespace App\Http\Requests\Api\V1\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommentRequest extends FormRequest
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
            'body'       => 'required|string|max:1000',
            'comment_id' => [
                'nullable',
                Rule::exists('comments', 'id')->where(function ($query) {
                    $query->where('comment_id', null)->where('commentable_id', $this->product->id);
                }),
            ],
        ];
    }
}
