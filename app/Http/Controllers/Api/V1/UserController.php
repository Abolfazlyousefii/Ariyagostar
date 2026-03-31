<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\UpdateUserAddressRequest;
use App\Http\Requests\Api\V1\User\UpdateUserRequest;
use App\Http\Resources\Api\V1\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user(User $user)
    {
        $user = auth()->user();

        return $this->respondWithResource(new UserResource($user));
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $user->update($data);

        return $this->respondWithResource(new UserResource($user));
    }

    public function updateAddress(UpdateUserAddressRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $user->address->updateOrCreate([], $data);
        $user->load('address');

        return $this->respondWithResource(new UserResource($user));
    }
}
