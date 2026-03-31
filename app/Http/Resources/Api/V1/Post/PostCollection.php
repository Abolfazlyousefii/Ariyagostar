<?php

namespace App\Http\Resources\Api\V1\Post;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($post) {

            if ($post->category) {
                $category = [
                    'id'     => $post->category->id,
                    'title'  => $post->category->title,
                    'slug'   => $post->category->slug,
                ];
            } else {
                $category = null;
            }

            return [
                'id'                   => $post->id,
                'title'                => $post->title,
                'slug'                 => $post->slug,
                'category'             => $category,
                'image'                => $post->image ? asset($post->image) : null,
                'view'                 => $post->view,
                'created_at'           => $post->created_at,
                'created_at_jalali'    => jdate($post->created_at)->format('Y-m-d'),
            ];
        });
    }
}
