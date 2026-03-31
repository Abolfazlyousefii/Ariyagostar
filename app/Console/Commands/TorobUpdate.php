<?php

namespace App\Console\Commands;

use App\Models\Torob;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TorobUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'torob:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Torob Prices';

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
        $torobs = Torob::whereHas('product', function ($q) {
            $q->published()->available();
        })->where(function ($q) {
            $q->where('last_update', '<', now()->subHours(24*4))->orWhereNull('last_update');
        })->where('check_torob', true)->oldest('last_update')->take(10)->get();

        foreach ($torobs as $torob) {
            $product = $torob->product;

            $torob->update([
                "price"             => null,
                "last_price_change" => null,
                "price_link"        => null,
                "shop_name"         => null,
                "title"             => null,
                "torob_link_id"     => null,
                "review_need"       => false,
                'last_update'       => now()
            ]);

            foreach ($torob->links as $link) {

                $pattern = '/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/';

                // Perform the regex search
                if (preg_match($pattern, $link->link, $matches)) {
                    $uuid = $matches[0]; // The first match is the UUID
                } else {
                    continue;
                }

                $url = "https://api.torob.com/v4/base-product/sellers/?source=next_desktop&discover_method=direct&_bt__experiment=&search_id=&cities=&province=&prk=$uuid&list_type=products_info";

                try {
                    $response = Http::get($url);

                    $data = $response->json();

                    $data = collect($data['results']);

                    $torob->update([
                        "is_merged" => $data->count() > 1,
                    ]);

                    $lowest_price = $data->where('price_text_mode', 'active')->sortBy('price')->first();

                    if ($lowest_price && $lowest_price['price'] < $product->getLowestPrice(true)) {
                        if (!$torob->price || $lowest_price['price'] < $torob->price) {
                            $torob->update([
                                "price"             => $lowest_price['price'],
                                "last_price_change" => $lowest_price['last_price_change_date'],
                                "price_link"        => $lowest_price['page_url'],
                                "shop_name"         => $lowest_price['shop_name'],
                                "title"             => $lowest_price['name1'],
                                "review_need"       => true,
                                "torob_link_id"     => $link->id
                            ]);
                        }
                    }

                    sleep(rand(10, 30));
                } catch (Exception $e) {
                    Log::error($e);
                }
            }
        }

        $this->info('done!');
    }
}
