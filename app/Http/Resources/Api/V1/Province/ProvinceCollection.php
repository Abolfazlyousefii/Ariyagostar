<?php

namespace App\Http\Resources\Api\V1\Province;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProvinceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($province) {
            return [
                'id'        => $province->id,
                'name'      => $province->name,
                'name_en'   => $province->name_en,
                'latitude'  => $province->latitude,
                'longitude' => $province->longitude,
                'ordering'  => $province->ordering,
            ];
        });
    }
}
