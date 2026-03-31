<?php

namespace App\Traits;

use App\Models\Statistics;
use App\Models\Viewer;
use Illuminate\Http\Request;

trait ViewStatisticsTrait
{
    use StatisticsTrait;

    public static function getViewStatisticsData($type, $period, $jalali_date, $start_date, $end_date)
    {
        $data = [];

        switch ($period) {
            case "weekly":
            case "daily": {
                    $data['chart_category'] = $jalali_date->format('%Y-%m- %d');
                    break;
                }
            case "monthly": {
                    $data['chart_category'] = $jalali_date->format('%B - %Y');
                    break;
                }
            case "yearly": {
                    $data['chart_category'] = $jalali_date->format('%Y');
                    break;
                }
        }

        switch ($type) {
            case "viewCounts": {
                    $data['total'] = Viewer::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->count();
                    $data['total'] += Statistics::whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->sum('view_count');
                    break;
                }
            case "viewerCounts": {
                    $data['total'] = Viewer::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->distinct('ip')->count();
                    $data['total'] += Statistics::whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date)->sum('viewer_count');
                    break;
                }
        }

        return $data;
    }

    protected function viewCounts(Request $request)
    {
        $this->authorize('statistics.views');

        $data = $this->getPeriodData('viewCounts', $request, [$this, "getViewStatisticsData"]);

        $total_count   = 0;
        $total         = 0;

        foreach ($data as $item) {
            $total         += $item['total'];
            $total_count   += 1;
        }

        $avg = $total / $total_count;

        return response()->json(
            [
                'data' => $data,
                'meta' => [
                    'total'         => formatPriceUnits($total),
                    'avg'           => formatPriceUnits($avg),
                ],
                'status' => 'success',
            ],
        );
    }

    protected function viewerCounts(Request $request)
    {
        $this->authorize('statistics.views');

        $data = $this->getPeriodData('viewerCounts', $request, [$this, "getViewStatisticsData"]);

        $total_count   = 0;
        $total         = 0;

        foreach ($data as $item) {
            $total         += $item['total'];
            $total_count   += 1;
        }

        $avg = $total / $total_count;

        return response()->json(
            [
                'data' => $data,
                'meta' => [
                    'total'         => formatPriceUnits($total),
                    'avg'           => formatPriceUnits($avg),
                ],
                'status' => 'success',
            ],
        );
    }
}
