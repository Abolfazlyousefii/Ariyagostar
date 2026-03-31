<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\Carrier\StoreCarrierRequest;
use App\Http\Requests\Back\Carrier\UpdateCarrierRequest;
use App\Models\Carrier;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarrierController extends Controller
{
    public function index()
    {
        $carriers = Carrier::detectLang()->latest()->paginate(20);

        return view('back.carriers.index', compact('carriers'));
    }

    public function create()
    {
        $provinces = Province::with('cities:id,province_id,name')->select('id', 'name')->get();

        return view('back.carriers.create', compact('provinces'));
    }

    public function store(StoreCarrierRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->image;
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $request->image->storeAs('carriers', $name);

            $data['image'] = '/uploads/' . $path;
        }

        $data['lang'] = app()->getLocale();

        $carrier = Carrier::create($data);

        $carrier->cities()->attach($request->included_cities);

        toastr()->success('روش ارسال با موفقیت ایجاد شد');

        return response('success');
    }

    public function edit(Carrier $carrier)
    {
        $provinces = Province::with('cities:id,province_id,name')->select('id', 'name')->get();

        return view('back.carriers.edit', compact('provinces', 'carrier'));
    }

    public function update(Carrier $carrier, UpdateCarrierRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->image;
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $request->image->storeAs('carriers', $name);

            if ($carrier->image) {
                Storage::disk('public')->delete($carrier->image);
            }

            $data['image'] = '/uploads/' . $path;
        } else {
            $data['image'] = $carrier->image;
        }

        $carrier->update($data);

        $carrier->cities()->sync($request->included_cities);

        toastr()->success('روش ارسال با موفقیت ویرایش شد');

        return response('success');
    }

    public function destroy(Carrier $carrier)
    {
        $carrier->delete();
        $carrier->cities()->detach();

        return response('success');
    }

    public function cities(Carrier $carrier)
    {
        return view('back.carriers.cities', compact('carrier'));
    }
}
