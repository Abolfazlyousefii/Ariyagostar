<?php

namespace App\Policies;

use App\Models\Filter;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilterPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('filters.index');
    }

    public function create(User $user)
    {
        return $user->can('filters.create');
    }

    public function update(User $user, Filter $filter)
    {
        return $user->can('filters.update');
    }

    public function delete(User $user, Filter $filter)
    {
        return $user->can('filters.delete');
    }
}
