<?php

namespace App\Exports;

use App\Exports\Sheets\ProductsImagesSheet;
use App\Exports\Sheets\ProductsListsSheet;
use App\Exports\Sheets\ProductsPricesSheet;
use App\Exports\Sheets\ProductsSpecificationsSheet;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductsExport implements WithMultipleSheets
{
    public $products;
    public $request;

    public function __construct($products, Request $request)
    {
        $this->products   = $products;
        $this->request    = $request;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new ProductsListsSheet($this->products);

        if (isset($this->request->filters['specifications'])) {
            $sheets[] = new ProductsSpecificationsSheet($this->products);
        }

        if (isset($this->request->filters['prices'])) {
            $sheets[] = new ProductsPricesSheet($this->products);
        }

        if (isset($this->request->filters['images'])) {
            $sheets[] = new ProductsImagesSheet($this->products);
        }

        return $sheets;
    }
}
