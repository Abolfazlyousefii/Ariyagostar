<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class OrdersProductsSheet implements FromView, WithTitle
{
    private $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function view(): View
    {
        return view('back.exports.orders-products', [
            'orders'      => $this->orders,
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'لیست محصولات سفارشات';
    }
}
