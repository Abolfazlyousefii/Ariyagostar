<?php

namespace App\Http\Resources\Api\V1\User;

use App\Http\Resources\Api\V1\Address\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'                        => $this->id,
            'first_name'                => $this->first_name,
            'last_name'                 => $this->last_name,
            'username'                  => $this->username,
            'email'                     => $this->email,
            'profile_photo_url'         => $this->profile_photo_url,
            'created_at'                => $this->created_at,
            'force_to_password_change'  => $this->force_to_password_change,
            'address'                   => new AddressResource($this->address)
        ];
    }
}
