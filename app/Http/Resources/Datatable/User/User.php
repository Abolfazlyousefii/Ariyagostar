<?php

namespace App\Http\Resources\Datatable\User;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'image'             => $this->imageUrl,
            'fullname'          => htmlspecialchars($this->fullname),
            'username'          => $this->username,
            'created_at'        => jdate($this->created_at)->format('%d %B %Y'),

            'links' => [
                'edit'    => route('admin.users.edit', ['user' => $this]),
                'show'    => route('admin.users.show', ['user' => $this]),
            ]
        ];
    }
}
