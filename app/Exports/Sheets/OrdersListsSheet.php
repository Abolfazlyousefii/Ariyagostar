<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class OrdersListsSheet implements FromView, WithTitle
{
    private $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function view(): View
    {
        return view('back.exports.orders-lists', [
            'orders'    => $this->orders,
            'request'   => request()
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'لیست سفارشات';
    }
}
