<?php

namespace App\Http\Controllers\Back;

use App\Models\Attribute;
use App\Models\AttributeGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Attribute::class, 'attribute');
    }

    public function create()
    {
        $attributeGroups = AttributeGroup::all();

        return view('back.attributes.create', compact('attributeGroups'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'               => 'required',
            'attribute_group_id' => 'required|exists:attribute_groups,id'
        ]);

        Attribute::create([
            'name'               => $request->name,
            'value'              => $request->value,
            'attribute_group_id' => $request->attribute_group_id,
            'ordering'           => $request->ordering,
        ]);

        toastr()->success('ویژگی با موفقیت ایجاد شد.');

        return response("success");
    }

    public function edit(Attribute $attribute)
    {
        $attributeGroups = AttributeGroup::all();

        return view('back.attributes.edit', compact('attribute', 'attributeGroups'));
    }

    public function update(Attribute $attribute, Request $request)
    {
        $this->validate($request, [
            'name'               => 'required',
            'attribute_group_id' => 'required|exists:attribute_groups,id'
        ]);

        $attribute->update([
            'name'               => $request->name,
            'value'              => $request->value,
            'attribute_group_id' => $request->attribute_group_id,
            'ordering'           => $request->ordering,
        ]);

        toastr()->success('ویژگی با موفقیت ویرایش شد.');

        return response("success");
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return response('success');
    }

    public function sort(Request $request)
    {
        $this->authorize('attributes.update');

        $this->validate($request, [
            'attributes' => 'required|array'
        ]);

        $i = null;

        foreach ($request->input('attributes') as $attribute) {
            $dbAttr = Attribute::findOrFail($attribute);

            if ($i === null) {
                $i = Attribute::whereIn('id', $request->input('attributes'))->min('ordering');
            }

            $dbAttr->update([
                'ordering' => $i++,
            ]);
        };

        return response('success');
    }
}
