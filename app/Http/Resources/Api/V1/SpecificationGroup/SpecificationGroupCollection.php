<?php

namespace App\Http\Resources\Api\V1\SpecificationGroup;

use App\Http\Resources\Api\V1\Specification\SpecificationCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SpecificationGroupCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $product = ($this->additional)['product'];

        return $this->collection->map(function ($group) use ($product) {
            $specifications = $product->specifications()->where('specification_group_id', $group->id)->get()->unique();

            return [
                'id'             => $group->id,
                'name'           => $group->name,
                'specifications' => new SpecificationCollection($specifications)
            ];
        });
    }
}
