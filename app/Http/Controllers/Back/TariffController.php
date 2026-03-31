<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\Tariff\StoreTariffRequest;
use App\Http\Requests\Back\Tariff\UpdateTariffRequest;
use App\Models\Carrier;
use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    public function index(Request $request)
    {
        $carrier = Carrier::findOrFail($request->carrier);
        $tariffs = $carrier->tariffs()->orderBy('type')->orderBy('max_weight')->paginate(20);

        return view('back.tariffs.index', compact('carrier', 'tariffs'));
    }

    public function create(Request $request)
    {
        $carrier = Carrier::findOrFail($request->carrier);

        return view('back.tariffs.create', compact('carrier'));
    }

    public function store(StoreTariffRequest $request)
    {
        $data = $request->validated();

        Tariff::create($data);

        toastr()->success('تعرفه با موفقیت ایجاد شد.');

        return response('success');
    }

    public function edit(Tariff $tariff)
    {
        return view('back.tariffs.edit', compact('tariff'));
    }

    public function update(UpdateTariffRequest $request, Tariff $tariff)
    {
        $data = $request->validated();

        $tariff->update($data);

        toastr()->success('تعرفه با موفقیت ویرایش شد.');

        return response('success');
    }

    public function destroy(Tariff $tariff)
    {
        $tariff->delete();

        return response('success');
    }
}
