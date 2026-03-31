<?php

namespace App\Http\Resources\Datatable\Province;

use Illuminate\Http\Resources\Json\JsonResource;

class ProvinceResource extends JsonResource
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
            'cities_count'      => $this->cities()->count(),
            'is_active'         => $this->is_active,

            'links' => [
                'edit'    => route('admin.provinces.edit', ['province' => $this]),
                'show'    => route('admin.provinces.show', ['province' => $this]),
            ]
        ];
    }
}
