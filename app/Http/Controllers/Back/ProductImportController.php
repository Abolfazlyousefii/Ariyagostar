<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\Product\ProductImportPreviewRequest;
use App\Http\Requests\Back\Product\ProductImportRunRequest;
use App\Services\ProductImport\ProductImportService;
use Illuminate\Support\Str;

class ProductImportController extends Controller
{
    public function __construct(private ProductImportService $service)
    {
    }

    public function index()
    {
        $this->authorize('products.create');

        return view('back.products.import.index', [
            'state' => null,
            'fields' => $this->service->mappableFields(),
            'duplicateStrategies' => $this->service->duplicateStrategies(),
        ]);
    }

    public function preview(ProductImportPreviewRequest $request)
    {
        $this->authorize('products.create');

        $importToken = Str::uuid()->toString();
        $state = $this->service->buildPreviewState(
            file: $request->file('excel_file'),
            importToken: $importToken,
            options: $request->validated(),
        );

        return view('back.products.import.index', [
            'state' => $state,
            'fields' => $this->service->mappableFields(),
            'duplicateStrategies' => $this->service->duplicateStrategies(),
        ]);
    }

    public function run(ProductImportRunRequest $request)
    {
        $this->authorize('products.create');

        $result = $this->service->runImport($request->validated());

        return view('back.products.import.index', [
            'state' => [
                'headers' => $result['headers'],
                'mapping' => $request->input('mapping', []),
                'sampleRows' => $result['sample_rows'],
                'importToken' => $request->input('import_token'),
                'options' => $request->only(['duplicate_strategy', 'create_missing_taxonomy', 'import_images']),
                'result' => $result,
            ],
            'fields' => $this->service->mappableFields(),
            'duplicateStrategies' => $this->service->duplicateStrategies(),
        ]);
    }
}
