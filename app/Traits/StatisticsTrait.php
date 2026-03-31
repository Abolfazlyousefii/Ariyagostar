<?php

namespace App\Traits;

use App\Rules\CheckJdate;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Morilog\Jalali\Jalalian;

trait StatisticsTrait
{
    protected function validateDates(Request $request)
    {
        $request->validate([
            'period'    => 'required|in:daily,weekly,monthly,yearly',
            'from_date' => ['nullable', new CheckJdate()],
            'to_date'   => ['nullable', new CheckJdate()],
        ]);

        $from_date = $request->from_date;
        $to_date   = $request->to_date;

        if ($to_date) {
            $to_date = Jalalian::fromFormat('Y-m-d', $request->to_date)->toCarbon();
        } else {
            $to_date = now();
        }

        if ($from_date) {
            $from_date = Jalalian::fromFormat('Y-m-d', $request->from_date)->toCarbon();
        } else {
            switch ($request->period) {
                case "daily": {
                        $from_date = Jalalian::fromCarbon($to_date)->subDays(29)->toCarbon();
                        break;
                    }
                case "weekly": {
                        $from_date = Jalalian::fromCarbon($to_date)->subDays(9 * 7)->toCarbon();
                        break;
                    }
                case "yearly": {
                        $from_date     = Jalalian::fromCarbon($to_date)->subYears(4);
                        $start_of_year = (new Jalalian($from_date->getYear(), 1, 1))->toCarbon();
                        $from_date     = $start_of_year;
                        break;
                    }
                default: {
                        $from_date      = Jalalian::fromCarbon($to_date)->subMonths(11);
                        $start_of_month = (new Jalalian($from_date->getYear(), $from_date->getMonth(), 1))->toCarbon();
                        $from_date      = $start_of_month;
                    }
            }
        }

        if ($from_date->gt($to_date)) {
            throw ValidationException::withMessages([
                'from_date' => 'لطفا بازه تاریخی را صحیح انتخاب کنید'
            ]);
        }

        return ['from_date' => $from_date, 'to_date' => $to_date];
    }

    protected function getPeriodData(string $type, Request $request, callable $getStatisticsData)
    {
        $dates      = $this->validateDates($request);
        $from_date  = $dates['from_date'];
        $to_date    = $dates['to_date'];

        $data  = [];
        $count = 1;

        switch ($request->period) {
            case "daily": {
                    while ($to_date->gte($from_date)) {
                        $start         = $from_date;
                        $jalali_date   = Jalalian::fromCarbon($from_date);
                        $end           = $jalali_date->toCarbon();

                        $data[$count] = $getStatisticsData($type, $request->period, $jalali_date, $start, $end);

                        $from_date = $end->addDays(1);

                        $count++;
                    }

                    break;
                }
            case "weekly": {

                    while ($to_date->gte($from_date)) {
                        $start         = $from_date;
                        $jalali_date   = Jalalian::fromCarbon($from_date);
                        $end           = $jalali_date->addDays(6)->toCarbon();
                        $end           = $to_date->gt($end) ? $end : $to_date->copy();

                        $data[$count] = $getStatisticsData($type, $request->period, $jalali_date, $start, $end);

                        $from_date = $end->addDays(1);

                        $count++;
                    }

                    break;
                }
            case "yearly": {

                    while ($to_date->gte($from_date)) {
                        $start         = $from_date;
                        $jalali_date   = Jalalian::fromCarbon($from_date);
                        $year          = $jalali_date->getYear();
                        $month         = $jalali_date->getMonth();
                        $last_day      = $jalali_date->isLeapYear() ? 30 : 29;
                        $end           = (new Jalalian($year, 12, $last_day))->toCarbon();
                        $end           = $to_date->gt($end) ? $end : $to_date->copy();

                        $data[$count] = $getStatisticsData($type, $request->period, $jalali_date, $start, $end);

                        $from_date = $end->addDays(1);

                        $count++;
                    }

                    break;
                }
            default: {

                    while ($to_date->gte($from_date)) {
                        $start         = $from_date;
                        $jalali_date   = Jalalian::fromCarbon($from_date);
                        $year          = $jalali_date->getYear();
                        $month         = $jalali_date->getMonth();
                        $last_day      = $jalali_date->getMonthDays();
                        $end           = (new Jalalian($year, $month, $last_day))->toCarbon();
                        $end           = $to_date->gt($end) ? $end : $to_date->copy();

                        $data[$count] = $getStatisticsData($type, $request->period, $jalali_date, $start, $end);

                        $from_date = $end->addDays(1);

                        $count++;
                    }
                }
        }

        return $data;
    }
}
