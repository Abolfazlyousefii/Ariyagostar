<?php

namespace App\Http\Controllers\Back;

use App\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:products.brands');
    }

    public function index()
    {
        $brands = Brand::detectLang()->filter()->withCount('products')->latest()->paginate(10);

        return view('back.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('back.brands.create');
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name'         => 'required',
            'lang'         => app()->getLocale(),
            'slug'         => 'required|unique:brands,slug',
            'description'  => 'nullable|string',
            'image'        => 'image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->image;
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $request->image->storeAs('brands', $name);

            $data['image'] = '/uploads/brands/' . $name;
        }

        Brand::create($data);

        toastr()->success('برند با موفقیت ایجاد شد.');

        return response("success");
    }

    public function edit(Brand $brand)
    {
        return view('back.brands.edit', compact('brand'));
    }

    public function update(Brand $brand, Request $request)
    {
        $data = $this->validate($request, [
            'name'         => 'required',
            'slug'         => 'required|unique:brands,slug,' . $brand->id,
            'description'  => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }

            $file = $request->image;
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $request->image->storeAs('brands', $name);

            $data['image'] = '/uploads/brands/' . $name;
        }

        $brand->update($data);

        toastr()->success('برند با موفقیت ویرایش شد.');

        return response("success");
    }

    public function destroy(Brand $brand)
    {
        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }

        $brand->delete();

        return response('success');
    }

    public function ajax_get(Request $request)
    {
        if ($request->term) {
            $brands = Brand::where('name', 'like', '%' . $request->term . '%')->pluck('name')->toArray();

            return $brands;
        }
    }
}
