<?php

namespace App\Http\Resources\Api\V1\Specification;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SpecificationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($specification) {
            return [
                'id'        => $specification->id,
                'name'      => $specification->name,
                'value'     => $specification->pivot->value,
            ];
        });
    }
}
