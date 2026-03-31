<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductsListsSheet implements FromView, WithTitle
{
    private $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function view(): View
    {
        return view('back.exports.products-lists', [
            'products'      => $this->products,
            'request'       => request(),
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'لیست محصولات';
    }
}
