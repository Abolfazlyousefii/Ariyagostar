<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixProbableProblems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix Probable Problems in Database';

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
        $deleted_prices = DB::table('prices')->whereNotNull('deleted_at')->pluck('id')->toArray();

        DB::table('cart_product')
            ->whereIn('price_id', $deleted_prices)
            ->delete();

        $this->info('app fix done');
    }
}
