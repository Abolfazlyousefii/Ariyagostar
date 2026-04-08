<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\Product\ImportProductsRequest;
use App\Services\Product\ProductExcelImportService;
use Illuminate\Http\Response;

class ProductImportController extends Controller
{
    public function index()
    {
        $this->authorize('products.create');

        return view('back.products.import');
    }

    public function store(ImportProductsRequest $request, ProductExcelImportService $importService)
    {
        $this->authorize('products.create');

        $summary = $importService->import($request->file('excel_file'));

        if ($summary['failed'] > 0) {
            toastr()->warning('ایمپورت با خطاهای جزئی انجام شد. گزارش را بررسی کنید.');
        } else {
            toastr()->success('ایمپورت محصولات با موفقیت انجام شد.');
        }

        return redirect()
            ->route('admin.products.import.index')
            ->with('import_summary', $summary);
    }

    public function sample(): Response
    {
        $this->authorize('products.create');

        $content = "product_id,product_name,categories\n1001,Sample Product 1,Category A|Category B\n1002,Sample Product 2,Category B;Category C\n";

        return response($content, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="products-import-template.csv"',
        ]);
    }
}
