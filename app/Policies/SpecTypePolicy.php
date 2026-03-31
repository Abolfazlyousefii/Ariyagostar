<?php

namespace App\Policies;

use App\Models\SpecType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('products.spectypes');
    }

    public function update(User $user, SpecType $specType)
    {
        return $user->can('products.spectypes');
    }

    public function delete(User $user, SpecType $specType)
    {
        return $user->can('products.spectypes');
    }
}
