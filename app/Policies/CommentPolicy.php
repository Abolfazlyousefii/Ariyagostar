<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('comments.index');
    }

    public function view(User $user, Comment $comment)
    {
        return $user->can('comments.view');
    }

    public function update(User $user, Comment $comment)
    {
        return $user->can('comments.update');
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->can('comments.delete');
    }
}
