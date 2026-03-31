<?php

namespace App\Console\Commands;

use App\Models\Price;
use Illuminate\Console\Command;

class ChangePrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:prices {amount}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'increase or decrease prices';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $type = $this->choice(
            'Select type',
            ['increase', 'decrease'],
        );

        $amount = (int) $this->argument('amount');

        if ($this->confirm('Do you wish to continue?')) {
            $prices = Price::where('stock', '>', 0)->get();

            foreach ($prices as $priceItem) {
                if ($type == 'increase') {
                    $discount_price = $priceItem->discount_price + $amount;
                    $regular_price  = $priceItem->regular_price + $amount;
                    $price          = $priceItem->price + $amount;
                } else {
                    $discount_price = $priceItem->discount_price - $amount;
                    $regular_price  = $priceItem->regular_price - $amount;
                    $price          = $priceItem->price - $amount;
                }

                $priceItem->update([
                    'discount_price' => $discount_price,
                    'regular_price'  => $regular_price,
                    'price'          => $price,
                ]);
            }
        }

        return 0;
    }
}
