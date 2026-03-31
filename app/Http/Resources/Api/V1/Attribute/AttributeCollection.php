<?php

namespace App\Http\Resources\Api\V1\Attribute;

use App\Http\Resources\Api\V1\AttributeGroup\AttributeGroupResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AttributeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($attribute) {
            return [
                'id'        => $attribute->id,
                'name'      => $attribute->name,
                'value'     => $attribute->value,
                'value'     => $attribute->value,
                'group'     => new AttributeGroupResource($attribute->group),
            ];
        });
    }
}
