<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\City\StoreCityRequest;
use App\Http\Requests\Back\City\UpdateCityRequest;
use App\Http\Resources\Datatable\City\CityCollection;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(City::class, 'city');
    }

    public function apiIndex(Province $province, Request $request)
    {
        $this->authorize('carriers.provinces.show');

        $cities = City::where('province_id', $province->id)->filter($request);

        $cities = datatable($request, $cities);

        return new CityCollection($cities);
    }

    public function create()
    {
        $provinces = Province::orderBy('ordering')->get();

        return view('back.cities.create', compact('provinces'));
    }

    public function store(StoreCityRequest $request)
    {
        $data             = $request->validated();
        $data['ordering'] = City::max('ordering') + 1;
        $data['lang']     = app()->getLocale();

        City::create($data);

        toastr()->success('شهر با موفقیت ایجاد شد.');

        return response('success');
    }

    public function edit(City $city)
    {
        $provinces = Province::orderBy('ordering')->get();

        return view('back.cities.edit', compact('city', 'provinces'));
    }

    public function update(City $city, UpdateCityRequest $request)
    {
        $data = $request->validated();

        $city->update($data);

        toastr()->success('شهر با موفقیت ویرایش شد.');

        return response('success');
    }

    public function destroy(City $city, $multiple = false)
    {
        $city->delete();

        if (!$multiple) {
            toastr()->success('شهر با موفقیت حذف شد.');
        }

        return response('success');
    }

    public function multipleDestroy(Request $request)
    {
        $this->authorize('carriers.cities.delete');

        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'required|exists:cities,id'
        ]);

        foreach ($request->ids as $id) {
            $city = City::find($id);
            $this->destroy($city, true);
        }

        return response('success');
    }

    public function sort(Request $request)
    {
        $this->authorize('carriers.cities.update');

        $this->validate($request, [
            'cities'    => 'required|array',
            'orderings' => 'required|array',
        ]);

        $orderings = implode(',', $request->orderings);
        $count = 0;

        $cities = City::whereIn('id', $request->cities)
            ->orderByRaw('FIELD(ordering,' . $orderings . ')')
            ->get();

        $sorted = $cities->sortBy('ordering')
            ->pluck('ordering')
            ->toArray();

        foreach ($cities as $city) {
            $city->update([
                'ordering' => $sorted[$count++],
            ]);
        };

        return response('success');
    }
}
