<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

trait OrderStatisticsTrait
{
    use StatisticsTrait;

    public static function getStatisticsData($type, $period, $jalali_date, $start_date, $end_date)
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
            case "orderCounts": {
                    $data['success_orders'] = Order::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->paid()->count();
                    $data['fail_orders']    = Order::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->notPaid()->count();
                    break;
                }
            case "orderValues": {
                    $data['success_orders'] = Order::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->paid()->sum('price');
                    $data['fail_orders']    = Order::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->notPaid()->sum('price');
                    break;
                }
            case "orderUsers": {
                    $data['success_orders'] = Order::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->paid()->distinct('user_id')->count('user_id');
                    $data['fail_orders']    = Order::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->notPaid()->distinct('user_id')->count('user_id');
                    break;
                }
            case "orderProducts": {
                    $data['success_orders'] = OrderItem::whereHas('order', function($query) use ($start_date, $end_date) {
                        $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->paid();
                    })->sum('quantity');

                    $data['fail_orders'] = OrderItem::whereHas('order', function($query) use ($start_date, $end_date) {
                        $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->notPaid();
                    })->sum('quantity');

                    break;
                }
        }

        return $data;
    }

    protected function orderValues(Request $request)
    {
        $this->authorize('statistics.orders');

        $data = $this->getPeriodData('orderValues', $request, [$this, "getStatisticsData"]);

        $total_count   = 0;
        $total         = 0;
        $total_success = 0;
        $total_fail    = 0;

        foreach ($data as $item) {
            $total         += $item['success_orders'] + $item['fail_orders'];
            $total_success += $item['success_orders'];
            $total_fail    += $item['fail_orders'];
            $total_count   += 1;
        }

        $avg = $total / $total_count;

        return response()->json(
            [
                'data' => $data,
                'meta' => [
                    'total'         => trans('messages.currency.prefix') . formatPriceUnits($total) . trans('messages.currency.suffix'),
                    'avg'           => trans('messages.currency.prefix') . formatPriceUnits($avg) . trans('messages.currency.suffix'),
                    'total_success' => trans('messages.currency.prefix') . formatPriceUnits($total_success) . trans('messages.currency.suffix'),
                    'total_fail'    => trans('messages.currency.prefix') . formatPriceUnits($total_fail) . trans('messages.currency.suffix')
                ],
                'status' => 'success',
            ],
        );
    }

    protected function orderCounts(Request $request)
    {
        $this->authorize('statistics.orders');

        $data = $this->getPeriodData('orderCounts', $request, [$this, "getStatisticsData"]);

        $total_count   = 0;
        $total         = 0;
        $total_success = 0;
        $total_fail    = 0;

        foreach ($data as $item) {
            $total         += $item['success_orders'] + $item['fail_orders'];
            $total_success += $item['success_orders'];
            $total_fail    += $item['fail_orders'];
            $total_count   += 1;
        }

        $avg = $total / $total_count;

        return response()->json(
            [
                'data' => $data,
                'meta' => [
                    'total'         => formatPriceUnits($total),
                    'avg'           => formatPriceUnits($avg),
                    'total_success' => formatPriceUnits($total_success),
                    'total_fail'    => formatPriceUnits($total_fail)
                ],
                'status' => 'success',
            ],
        );
    }

    protected function orderProducts(Request $request)
    {
        $this->authorize('statistics.orders');

        $data = $this->getPeriodData('orderProducts', $request, [$this, "getStatisticsData"]);

        $total_count   = 0;
        $total         = 0;
        $total_success = 0;
        $total_fail    = 0;

        foreach ($data as $item) {
            $total         += $item['success_orders'] + $item['fail_orders'];
            $total_success += $item['success_orders'];
            $total_fail    += $item['fail_orders'];
            $total_count   += 1;
        }

        $avg = $total / $total_count;

        return response()->json(
            [
                'data' => $data,
                'meta' => [
                    'total'         => formatPriceUnits($total),
                    'avg'           => formatPriceUnits($avg),
                    'total_success' => formatPriceUnits($total_success),
                    'total_fail'    => formatPriceUnits($total_fail)
                ],
                'status' => 'success',
            ],
        );
    }

    protected function orderUsers(Request $request)
    {
        $this->authorize('statistics.orders');

        $data = $this->getPeriodData('orderUsers', $request, [$this, "getStatisticsData"]);

        $total_count   = 0;
        $total         = 0;
        $total_success = 0;
        $total_fail    = 0;

        foreach ($data as $item) {
            $total         += $item['success_orders'] + $item['fail_orders'];
            $total_success += $item['success_orders'];
            $total_fail    += $item['fail_orders'];
            $total_count   += 1;
        }

        $avg = $total / $total_count;

        return response()->json(
            [
                'data' => $data,
                'meta' => [
                    'total'         => formatPriceUnits($total),
                    'avg'           => formatPriceUnits($avg),
                    'total_success' => formatPriceUnits($total_success),
                    'total_fail'    => formatPriceUnits($total_fail)
                ],
                'status' => 'success',
            ],
        );
    }
}
