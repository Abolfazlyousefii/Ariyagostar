<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Services\ProductImport\ProcessedProductImportService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductImportController extends Controller
{
    public function index()
    {
        $this->authorize('products.create');

        return view('back.products.import');
    }

    public function store(Request $request, ProcessedProductImportService $importService)
    {
        $this->authorize('products.create');

        $validated = $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv,txt',
        ]);

        $result = $importService->import($validated['excel_file']->getRealPath(), app()->getLocale());

        if (($result['imported'] + $result['updated']) > 0) {
            toastr()->success('عملیات ایمپورت با موفقیت انجام شد.');
        } else {
            toastr()->warning('هیچ محصولی ایمپورت نشد. لطفا فایل را بررسی کنید.');
        }

        return redirect()->route('admin.products.import.index')->with('import_result', $result);
    }

    public function sample(): StreamedResponse
    {
        $this->authorize('products.create');

        $content = implode("\n", [
            'product_id,product_name,categories',
            'EXT-1001,Sample Product 1,"Electronics > Mobile; Accessories"',
            'EXT-1002,Sample Product 2,"Home/Kitchen|Appliances"',
        ]);

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, 'processed-products-sample.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}

