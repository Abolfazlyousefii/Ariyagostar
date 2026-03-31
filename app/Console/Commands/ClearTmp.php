<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearTmp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:tmp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear tmp folder';

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
        $folderPath = public_path('uploads/tmp');

        // Get all files in the folder
        $files = File::files($folderPath);

        // Get the current time minus one hour
        $oneHourAgo = now()->subHour();

        foreach ($files as $file) {
            $fileCreationTime = File::lastModified($file);

            // Check if the file was created more than one hour ago
            if ($fileCreationTime < $oneHourAgo->timestamp) {
                File::delete($file); // Delete the file
            }
        }

        $this->info('clear:tmp done!');

        return 0;
    }
}
