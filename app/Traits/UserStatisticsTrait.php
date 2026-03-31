<?php

namespace App\Traits;


use App\Models\User;
use Illuminate\Http\Request;

trait UserStatisticsTrait
{
    use StatisticsTrait;

    public static function getUserStatisticsData($type, $period, $jalali_date, $start_date, $end_date)
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
            case "userCounts": {
                    $data['users'] = User::excludeCreator()->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->count();
                    break;
                }
        }

        return $data;
    }

    protected function userCounts(Request $request)
    {
        $this->authorize('statistics.users');

        $data = $this->getPeriodData('userCounts', $request, [$this, "getUserStatisticsData"]);

        $total_count   = 0;
        $total         = 0;

        foreach ($data as $item) {
            $total         += $item['users'];
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
