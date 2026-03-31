<?php

namespace App\Http\Resources\Datatable\City;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'ordering'          => $this->ordering,
            'name'              => $this->name,
            'is_active'         => $this->is_active,

            'links' => [
                'edit'    => route('admin.cities.edit', ['city' => $this]),
            ]
        ];
    }
}
