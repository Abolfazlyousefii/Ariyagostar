<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductsPricesSheet implements FromView, WithTitle
{
    private $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function view(): View
    {
        return view('back.exports.products-prices', [
            'products'      => $this->products,
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'لیست قیمت ها';
    }
}
