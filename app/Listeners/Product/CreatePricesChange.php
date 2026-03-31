<?php

namespace App\Listeners\Product;

use App\Events\ProductPricesChanged;
use App\Models\Price;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreatePricesChange
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\ProductPricesChanged  $event
     * @return void
     */
    public function handle(ProductPricesChanged $event)
    {
        $product = $event->product;
        $prices  = $product->prices()->withTrashed()->get();

        foreach ($prices as $price) {
            $price->changes()->whereDate('created_at', '>', now())->delete();

            $last_change = $price->changes()->where('created_at', '<', now())->latest()->first();

            if ($price->discount_expire_at && $price->discount_expire_at->gt(now())) {
                $this->createChange($price, $price->discount_expire_at);
            }

            if (
                !$last_change ||
                $last_change->price != $price->salePrice() ||
                $last_change->discount != $price->discount()
            ) {
                $this->createChange($price);
                continue;
            }

            $is_available = $price->stock > 0 || $price->product->isDownload();

            if ($last_change->is_available != $is_available) {
                $this->createChange($price);
            }
        }
    }


    private function createChange(Price $price, $date = null)
    {
        if ($date) {
            $price->changes()->firstOrCreate([
                'product_id'   => $price->product_id,
                'price'        => $price->salePrice(),
                'discount'     => 0,
                'is_available' => $price->stock > 0 || $price->product->isDownload(),
                'created_at'   => $date
            ]);
        } else {
            $price->changes()->create([
                'product_id'   => $price->product_id,
                'price'        => $price->regularPrice(),
                'discount'     => $price->discount(),
                'is_available' => $price->stock > 0 || $price->product->isDownload(),
            ]);
        }
    }
}
