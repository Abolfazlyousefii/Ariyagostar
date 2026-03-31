<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\Province\StoreProvinceRequest;
use App\Http\Requests\Back\Province\UpdateProvinceRequest;
use App\Http\Resources\Datatable\Province\ProvinceCollection;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Province::class, 'province');
    }

    public function index()
    {
        return view('back.provinces.index');
    }

    public function apiIndex(Request $request)
    {
        $this->authorize('carriers.provinces.index');

        $provinces = Province::detectLang()->filter($request);

        $provinces = datatable($request, $provinces);

        return new ProvinceCollection($provinces);
    }

    public function show(Province $province)
    {
        return view('back.cities.index', compact('province'));
    }

    public function create()
    {
        return view('back.provinces.create');
    }

    public function store(StoreProvinceRequest $request)
    {
        $data             = $request->validated();
        $data['ordering'] = Province::max('ordering') + 1;
        $data['lang']     = app()->getLocale();

        Province::create($data);

        toastr()->success('استان با موفقیت ایجاد شد.');

        return response('success');
    }

    public function edit(Province $province)
    {
        return view('back.provinces.edit', compact('province'));
    }

    public function update(Province $province, UpdateProvinceRequest $request)
    {
        $data = $request->validated();

        $province->update($data);

        toastr()->success('استان با موفقیت ویرایش شد.');

        return response('success');
    }

    public function destroy(Province $province, $multiple = false)
    {
        $province->delete();

        if (!$multiple) {
            toastr()->success('استان با موفقیت حذف شد.');
        }

        return response('success');
    }

    public function multipleDestroy(Request $request)
    {
        $this->authorize('carriers.provinces.delete');

        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'required|exists:provinces,id'
        ]);

        foreach ($request->ids as $id) {
            $province = Province::find($id);
            $this->destroy($province, true);
        }

        return response('success');
    }

    public function sort(Request $request)
    {
        $this->authorize('carriers.provinces.update');

        $this->validate($request, [
            'provinces' => 'required|array',
            'orderings' => 'required|array',
        ]);

        $orderings = implode(',', $request->orderings);
        $count = 0;

        $provinces = Province::whereIn('id', $request->provinces)
            ->orderByRaw('FIELD(ordering,' . $orderings . ')')
            ->get();

        $sorted = $provinces->sortBy('ordering')
            ->pluck('ordering')
            ->toArray();

        foreach ($provinces as $province) {
            $province->update([
                'ordering' => $sorted[$count++],
            ]);
        };

        return response('success');
    }

    public function getCities(Request $request)
    {
        $province = Province::findOrFail($request->id);

        return response()->json($province->cities()->orderBy('ordering')->active()->get(['id', 'name']));
    }
}
