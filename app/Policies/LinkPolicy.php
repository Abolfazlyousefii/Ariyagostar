<?php

namespace App\Policies;

use App\Models\Link;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LinkPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('links.index');
    }

    public function create(User $user)
    {
        return $user->can('links.create');
    }

    public function update(User $user, Link $link)
    {
        return $user->can('links.update');
    }

    public function delete(User $user, Link $link)
    {
        return $user->can('links.delete');
    }
}
