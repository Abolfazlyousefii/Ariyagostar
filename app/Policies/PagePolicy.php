<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('pages.index');
    }

    public function create(User $user)
    {
        return $user->can('pages.create');
    }

    public function update(User $user, Page $page)
    {
        return $user->can('pages.update');
    }

    public function delete(User $user, Page $page)
    {
        return $user->can('pages.delete');
    }
}
