<?php

namespace App\Http\Controllers\Back;

use App\Models\AttributeGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttributeGroupController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(AttributeGroup::class, 'attributeGroup');
    }

    public function index()
    {
        $attributeGroups = AttributeGroup::detectLang()->orderBy('ordering')->get();

        return view('back.attributeGroups.index', compact('attributeGroups'));
    }

    public function attributesIndex(AttributeGroup $attributeGroup)
    {
        $attributes = $attributeGroup->get_attributes()->orderBy('ordering')->orderBy('name')->filter()->paginate(15);

        return view('back.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('back.attributeGroups.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required|in:color,checkbox,select',
        ]);

        $ordering = AttributeGroup::max('ordering') + 1;

        AttributeGroup::create([
            'name'       => $request->name,
            'lang'       => app()->getLocale(),
            'type'       => $request->type,
            'ordering'   => $ordering
        ]);

        toastr()->success('گروه ویژگی با موفقیت ایجاد شد.');

        return response("success");
    }

    public function edit(AttributeGroup $attributeGroup)
    {
        return view('back.attributeGroups.edit', compact('attributeGroup'));
    }

    public function update(AttributeGroup $attributeGroup, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required|in:color,checkbox,select',
        ]);

        $attributeGroup->update([
            'name'       => $request->name,
            'type'       => $request->type,
        ]);

        toastr()->success('گروه ویژگی با موفقیت ویرایش شد.');

        return response("success");
    }

    public function destroy(AttributeGroup $attributeGroup)
    {
        $attributeGroup->delete();

        return response('success');
    }

    public function sort(Request $request)
    {
        $this->authorize('attributes.groups.update');

        $this->validate($request, [
            'attributeGroups' => 'required|array'
        ]);

        $i = 1;

        foreach ($request->attributeGroups as $attributeGroup) {
            AttributeGroup::findOrFail($attributeGroup)->update([
                'ordering' => $i++,
            ]);
        };

        return response('success');
    }
}
