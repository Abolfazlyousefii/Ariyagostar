<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ThemeConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Config theme at the first time';

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
        run_theme_config();

        return 0;
    }
}
