<?php

namespace App\Exports;

use App\Exports\Sheets\OrdersListsSheet;
use App\Exports\Sheets\OrdersProductsSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OrdersExport implements WithMultipleSheets
{
    public $orders;
    public $request;

    public function __construct($orders)
    {
        $this->orders  = $orders;
        $this->request = request();
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new OrdersListsSheet($this->orders);

        if (isset($this->request->filters['products'])) {
            $sheets[] = new OrdersProductsSheet($this->orders);
        }

        return $sheets;
    }
}
