<?php

namespace App\Console\Commands;

use Codedge\Updater\UpdaterManager;
use Illuminate\Console\Command;

class UpdaterUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updater:update';

    protected $updater;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UpdaterManager $updater)
    {
        parent::__construct();

        $this->updater = $updater;

        ini_set('max_execution_time', '300');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $updater = $this->updater;

        // Check if new version is available
        if ($updater->source()->isNewVersionAvailable()) {

            // Get the new version available
            $versionAvailable = $updater->source()->getVersionAvailable();

            // Create a release
            $release = $updater->source()->fetch($versionAvailable);

            // Run the update process
            $updater->source()->update($release);
        }

        return 0;
    }
}
