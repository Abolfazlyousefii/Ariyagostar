<?php

namespace App\Http\Resources\Api\V1\Gallery;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GalleryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($gallery) {
            return [
                'id'        => $gallery->id,
                'image'     => asset($gallery->image),
                'ordering'  => $gallery->ordering,
            ];
        });
    }
}
