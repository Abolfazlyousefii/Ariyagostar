<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Slider::class, 'slider');
    }

    public function index()
    {
        $sliders = Slider::detectLang()->orderBy('ordering')->get();

        return view('back.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('back.sliders.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'image|required|max:2048',
            'group' => 'required'
        ]);

        $file = $request->image;
        $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $request->image->storeAs('sliders', $name);

        Slider::create([
            'title'       => $request->title,
            'link'        => $request->link,
            'group'       => $request->group,
            'description' => $request->description,
            'published'   => $request->published ? true : false,
            'image'       => '/uploads/sliders/' . $name,
            'lang'        => app()->getLocale(),
        ]);

        toastr()->success('اسلایدر با موفقیت ایجاد شد.');

        return response("success");
    }

    public function edit(Slider $slider)
    {
        return view('back.sliders.edit', compact('slider'));
    }

    public function update(Slider $slider, Request $request)
    {
        $this->validate($request, [
            'image' => 'image|max:2048',
            'group' => 'required'
        ]);

        if ($request->hasFile('image')) {

            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }

            $file = $request->image;
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $request->image->storeAs('sliders', $name);

            $slider->image = '/uploads/sliders/' . $name;
            $slider->save();
        }

        $slider->update([
            'title'       => $request->title,
            'link'        => $request->link,
            'group'       => $request->group,
            'description' => $request->description,
            'published'   => $request->published ? true : false,
        ]);

        toastr()->success('اسلایدر با موفقیت ویرایش شد.');

        return response("success");
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return response('success');
    }

    public function sort(Request $request)
    {
        $this->authorize('sliders.update');

        $this->validate($request, [
            'sliders' => 'required|array'
        ]);

        $i = 1;

        foreach ($request->sliders as $slider) {
            Slider::findOrFail($slider)->update([
                'ordering' => $i++,
            ]);
        };

        return response('success');
    }
}
