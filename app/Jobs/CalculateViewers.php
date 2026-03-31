<?php

namespace App\Jobs;

use App\Models\Statistics;
use App\Models\Viewer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateViewers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $date = now()->subDays(10);

        $viewers = Viewer::selectRaw('date(created_at) as date,  count(*) as views, count(distinct ip) as viewer')
            ->whereDate('created_at', '<', $date)
            ->groupBy('date')
            ->latest('date')
            ->get();

        foreach ($viewers as $viewer) {
            Statistics::firstOrCreate(
                [
                    'date'         => $viewer->date,
                ],
                [
                    'view_count'   => $viewer->views,
                    'viewer_count' => $viewer->viewer,
                ]
            );
        }

        Viewer::whereDate('created_at', '<', $date)->delete();
    }
}
