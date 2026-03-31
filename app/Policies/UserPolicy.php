<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('users.index');
    }

    public function view(User $user, User $model)
    {
        return $user->can('users.view');
    }

    public function create(User $user)
    {
        return $user->can('users.create');
    }

    public function update(User $user, User $model)
    {
        return $user->can('users.update') && ($model->level != 'creator');
    }

    public function delete(User $user, User $model)
    {
        return $user->can('users.delete') && ($model->level != 'creator');
    }
}
