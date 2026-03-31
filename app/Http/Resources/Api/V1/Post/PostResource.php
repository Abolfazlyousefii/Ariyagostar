<?php

namespace App\Http\Resources\Api\V1\Post;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->category) {
            $category = [
                'id'     => $this->category->id,
                'title'  => $this->category->title,
                'slug'   => $this->category->slug,
            ];
        } else {
            $category = null;
        }

        return [
            'id'                   => $this->id,
            'title'                => $this->title,
            'category'             => $category,
            'slug'                 => $this->slug,
            'image'                => $this->image ? asset($this->image) : null,
            'view'                 => $this->view,
            'content'              => $this->content,
            'created_at'           => $this->created_at,
            'created_at_jalali'    => jdate($this->created_at)->format('Y-m-d'),
        ];
    }
}
