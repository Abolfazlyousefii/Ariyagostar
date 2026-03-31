<?php

namespace App\Policies;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BannerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('banners.index');
    }

    public function create(User $user)
    {
        return $user->can('banners.create');
    }

    public function update(User $user, Banner $banner)
    {
        return $user->can('banners.update');
    }

    public function delete(User $user, Banner $banner)
    {
        return $user->can('banners.delete');
    }
}
