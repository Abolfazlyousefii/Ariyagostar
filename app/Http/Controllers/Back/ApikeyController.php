<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\Back\Apikey\StoreApikeyRequest;
use App\Http\Requests\Back\Apikey\UpdateApikeyRequest;
use App\Models\Apikey;
use Illuminate\Http\Request;

class ApikeyController extends Controller
{
    public function index()
    {
        $apikeys = Apikey::latest()->get();

        return view('back.apikeys.index', compact('apikeys'));
    }

    public function create()
    {
        return view('back.apikeys.create');
    }

    public function store(StoreApikeyRequest $request)
    {
        $data = $request->validated();

        Apikey::create($data);

        toastr()->success('کلید وب سرویس با موفقیت ایجاد شد.');

        return response('success');
    }

    public function edit(Apikey $apikey)
    {
        return view('back.apikeys.edit', compact('apikey'));
    }

    public function update(Apikey $apikey, UpdateApikeyRequest $request)
    {
        $data = $request->validated();

        $apikey->update($data);

        toastr()->success('کلید وب سرویس با موفقیت ویرایش شد.');

        return response('success');
    }

    public function destroy(Apikey $apikey)
    {
        $apikey->delete();

        return response('success');
    }
}
