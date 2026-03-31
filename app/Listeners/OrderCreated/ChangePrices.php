<?php

namespace App\Listeners\OrderCreated;

use App\Events\OrderCreated;
use App\Events\ProductPricesChanged;

class ChangePrices
{
    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        if (!$event->order->hasPhysicalProduct()) {
            return;
        }

        foreach ($event->order->items()->get() as $item) {
            $price   = $item->get_price;
            $product = $price->product;

            if ($price) {
                if ($product->isPhysical()) {
                    $price->update([
                        'stock' => $price->stock - $item->quantity
                    ]);

                    event(new ProductPricesChanged($product));
                }
            }
        }
    }
}
