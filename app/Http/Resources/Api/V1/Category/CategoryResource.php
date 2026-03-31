<?php

namespace App\Http\Resources\Api\V1\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'image'          => $this->image ? asset($this->image) : null,
            'title'          => $this->title,
            'slug'           => $this->slug,
            'categories'     => new CategoryCollection($this->categories),
            'category_id'    => $this->category_id,
            'products_count' => $this->productsCount()
        ];
    }
}
