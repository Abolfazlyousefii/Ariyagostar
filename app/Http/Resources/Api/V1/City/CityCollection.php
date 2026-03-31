<?php

namespace App\Http\Resources\Api\V1\City;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CityCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($city) {
            return [
                'id'          => $city->id,
                'name'        => $city->name,
                'name_en'     => $city->name_en,
                'latitude'    => $city->latitude,
                'longitude'   => $city->longitude,
                'ordering'    => $city->ordering,
            ];
        });
    }
}
