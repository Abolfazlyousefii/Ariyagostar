<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;

class ShopLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'link theme assets and storage';

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
        $links  = config('filesystems.links');
        $theme_links = config('front.links');

        if (is_array($theme_links)) {
            $links = array_merge($links, $theme_links);
        }

        foreach ($links as $link => $target) {
            try {
                if (!function_exists('symlink')) throw new Exception('symlink function does not exists');

                symlink($target, $link);
            } catch (Exception $e) {
                try {
                    if (!$this->isWindows()) {
                        $schedule = new Schedule();
                        $event = $schedule->exec('ln -s ' . $target . ' ' . $link);
                        $event->run($this->laravel);
                    } else {
                        $schedule = new Schedule();

                        $mode = is_dir($target) ? 'J' : 'H';
                        $event = $schedule->exec("mklink /{$mode} " . escapeshellarg($link) . ' ' . escapeshellarg($target));
                        $event->run($this->laravel);
                    }
                } catch (Exception $e) {
                    //
                }
            }
        }

        if (is_array($theme_links)) {
            foreach ($theme_links as $link => $target) {
                if (!File::exists($link) || str_replace('\\', '/', realpath($link)) == str_replace('\\', '/', $link)) {
                    if (!File::exists($link)) {
                        File::makeDirectory($link);
                    }
                    File::copyDirectory($target, $link);
                }
            }
        }


        $this->line("linked successfully.\n");

        return 0;
    }

    protected function isWindows(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }
}
