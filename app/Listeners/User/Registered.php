<?php

namespace App\Listeners\User;

use App\Models\User;
use App\Notifications\User\UserCreated;
use App\Notifications\User\UserRegistered;
use Illuminate\Auth\Events\Registered as RegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class Registered
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(RegisteredEvent $event)
    {
        store_user_cart($event->user);

        // send notification for admins
        $admins = User::whereIn('level', ['admin', 'creator'])->get();
        Notification::send($admins, new UserRegistered($event->user));

        if (option('sms_on_user_register', 'off') == 'on') {
            // send sms notification to user
            Notification::send($event->user, new UserCreated($event->user));
        }
    }
}
