<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Size;
use App\Models\SizeType;
use Illuminate\Http\Request;

class SizeTypeController extends Controller
{
    public function index()
    {
        $sizetypes = SizeType::detectLang()->latest()->paginate(15);

        return view('back.sizetypes.index', compact('sizetypes'));
    }

    public function show(SizeType $sizetype)
    {
        return view('back.sizetypes.show', compact('sizetype'));
    }

    public function create()
    {
        return view('back.sizetypes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => ['required', 'unique:size_types,title'],
            'sizes'       => ['required'],
            'description' => 'nullable|string'
        ]);

        $sizetype = SizeType::create([
            'title'       => $request->title,
            'description' => $request->description
        ]);

        $ordering = 1;

        foreach ($request->sizes as $title) {
            $sizetype->sizes()->create([
                'title'    => $title,
                'ordering' => $ordering++
            ]);
        }

        toastr()->success('راهنمای سایز با موفقیت ایجاد شد');

        return response('success');
    }

    public function edit(SizeType $sizetype)
    {
        return view('back.sizetypes.edit', compact('sizetype'));
    }

    public function update(Request $request, SizeType $sizetype)
    {
        $request->validate([
            'title'       => ['required', 'unique:size_types,title,' . $sizetype->id],
            'sizes'       => ['required', 'array'],
            'description' => 'nullable|string'
        ]);

        $sizetype->update([
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        $ordering = 1;

        $sizes = [];

        foreach ($request->sizes as $key => $title) {
            $id = $request->sizes_id[$key] ?? null;
            if ($id) {
                $size = $sizetype->sizes()->where('id', $id)->first();
                $size->update([
                    'title'    => $title,
                    'ordering' => $ordering++
                ]);
            } else {
                $size = $sizetype->sizes()->create([
                    'title'    => $title,
                    'ordering' => $ordering++
                ]);
            }

            $sizes[] = $size->id;
        }

        $sizetype->sizes()->whereNotIn('id', $sizes)->delete();

        toastr()->success('راهنمای سایز با موفقیت ویرایش شد');

        return response('success');
    }

    public function destroy(SizeType $sizetype)
    {
        $sizetype->delete();

        return response('success');
    }

    public function editValues(SizeType $sizetype)
    {
        return view('back.sizetypes.values', compact('sizetype'));
    }

    public function updateValues(Request $request, SizeType $sizetype)
    {
        $sizetype->values()->detach();
        $ordering      = 1;
        $groupordering = 1;

        foreach ($request->values as $group => $values) {

            foreach ($values as $size_id => $value) {
                $sizetype->values()->attach(
                    [
                        $size_id => [
                            'group'    => $groupordering,
                            'value'    => $value,
                            'ordering' => $ordering++
                        ]
                    ]
                );
            }

            $groupordering++;
        }

        toastr()->success('راهنمای سایز با موفقیت ویرایش شد');

        return response('success');
    }
}
