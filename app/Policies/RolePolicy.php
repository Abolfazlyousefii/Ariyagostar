<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('roles.index');
    }

    public function create(User $user)
    {
        return $user->can('roles.create');
    }

    public function update(User $user, Role $role)
    {
        return $user->can('roles.update');
    }

    public function delete(User $user, Role $role)
    {
        return $user->can('roles.delete');
    }
}
