<?php

namespace App\Listeners\OrderCreated;

use App\Models\Address;
use App\Events\OrderCreated;

class SaveAddress
{

    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        if (!$event->order->user || !$event->order->hasPhysicalProduct() || $event->order->reserved() || !$event->order->province_id) {
            return;
        }

        $address = $event->order->user->address;

        if (!$address) {
            Address::create([
                'province_id' => $event->order->province_id,
                'city_id'     => $event->order->city_id,
                'postal_code' => $event->order->postal_code,
                'address'     => $event->order->address,
                'user_id'     => $event->order->user->id,
            ]);
        }
    }
}
