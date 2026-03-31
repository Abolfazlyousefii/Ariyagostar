<?php

namespace App\Policies;

use App\Models\City;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CityPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->can('carriers.cities.create');
    }

    public function update(User $user, City $city)
    {
        return $user->can('carriers.cities.update');
    }

    public function delete(User $user, City $city)
    {
        return $user->can('carriers.cities.delete');
    }
}
