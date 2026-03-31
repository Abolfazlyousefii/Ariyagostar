<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('tickets.index');
    }

    public function view(User $user, Ticket $ticket)
    {
        return $user->can('tickets.show');
    }

    public function create(User $user)
    {
        return $user->can('tickets.create');
    }

    public function update(User $user, Ticket $ticket)
    {
        return $user->can('tickets.update');
    }

    public function delete(User $user, Ticket $ticket)
    {
        return $user->can('tickets.delete');
    }
}
