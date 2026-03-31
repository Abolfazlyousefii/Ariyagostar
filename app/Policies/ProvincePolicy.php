<?php

namespace App\Policies;

use App\Models\Province;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProvincePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('carriers.provinces.index');
    }

    public function view(User $user, Province $province)
    {
        return $user->can('carriers.provinces.show');
    }

    public function create(User $user)
    {
        return $user->can('carriers.provinces.create');
    }

    public function update(User $user, Province $province)
    {
        return $user->can('carriers.provinces.update');
    }

    public function delete(User $user, Province $province)
    {
        return $user->can('carriers.provinces.delete');
    }
}
