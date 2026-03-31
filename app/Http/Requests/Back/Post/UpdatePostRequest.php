<?php

namespace App\Http\Requests\Back\Post;

use App\Rules\CheckJdate;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title'              => 'required|string|max:191',
            'content'            => 'nullable|string',
            'category_id'        => 'required|exists:categories,id',
            'published'          => 'nullable',
            'image'              => 'image',
            'slug'               => 'nullable|unique:posts,slug,' . $this->post->id,
            'publish_date'       => ['nullable', new CheckJdate('Y-m-d H:i:s')],
            'meta_title'         => 'nullable',
            'meta_description'   => 'nullable',
        ];
    }
}
