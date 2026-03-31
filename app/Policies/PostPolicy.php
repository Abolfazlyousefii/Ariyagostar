<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('posts.index');
    }

    public function create(User $user)
    {
        return $user->can('posts.create');
    }

    public function update(User $user, Post $post)
    {
        return $user->can('posts.update');
    }

    public function delete(User $user, Post $post)
    {
        return $user->can('posts.delete');
    }
}
