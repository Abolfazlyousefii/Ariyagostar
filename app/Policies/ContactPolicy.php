<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('contacts.index');
    }

    public function view(User $user, Contact $contact)
    {
        return $user->can('contacts.view');
    }

    public function delete(User $user, Contact $contact)
    {
        return $user->can('contacts.delete');
    }
}
