<?php

namespace App\Http\Resources\Api\V1\Address;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $province = [
            'id'       => $this->province->id,
            'name'     => $this->province->name,
            'name_en'  => $this->province->name_en,
        ];

        $city = [
            'id'       => $this->city->id,
            'name'     => $this->city->name,
            'name_en'  => $this->city->name_en,
        ];

        return [
            'id'             => $this->id,
            'province'       => $province,
            'city'           => $city,
            'postal_code'    => $this->postal_code,
            'address'        => $this->address,
        ];
    }
}
