<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Specification;
use App\Models\SpecificationGroup;
use App\Models\SpecType;
use Illuminate\Http\Request;

class SpecTypeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SpecType::class, 'spectype');
    }

    public function index()
    {
        $spectypes = SpecType::detectLang()->latest()->paginate(15);

        return view('back.spectypes.index', compact('spectypes'));
    }

    public function edit(SpecType $spectype)
    {
        return view('back.spectypes.edit', compact('spectype'));
    }

    public function update(SpecType $spectype, Request $request)
    {
        $request->validate([
            'name' => 'required|unique:spec_types,name,' . $spectype->id
        ]);

        $spectype->update([
            'name' => $request->name
        ]);

        $spectype->specifications()->detach();
        $group_ordering = 0;

        if ($request->specification_group) {
            foreach ($request->specification_group as $group) {

                if (!isset($group['specifications'])) {
                    continue;
                }

                $spec_group = SpecificationGroup::firstOrCreate([
                    'name'        => $group['name'],
                    'lang'        => app()->getLocale(),
                ]);

                $specification_ordering = 0;

                foreach ($group['specifications'] as $specification) {
                    $spec = Specification::firstOrCreate([
                        'name' => $specification['name']
                    ]);

                    $spectype->specifications()->attach([
                        $spec->id => [
                            'specification_group_id' => $spec_group->id,
                            'group_ordering'         => $group_ordering,
                            'specification_ordering' => $specification_ordering++,
                        ]
                    ]);
                }

                $group_ordering++;
            }
        }

        toastr()->success('نوع مشخصات با موفقیت ویرایش شد.');

        return response("success", 200);
    }

    public function getData(Request $request)
    {
        $spec_type          = SpecType::detectLang()->where('name', $request->name)->firstOrFail();
        $view               = view('back.spectypes.getdata', compact('spec_type'))->render();
        $groupCount         = $spec_type->specificationGroups->unique()->count();
        $specificationCount = $spec_type->specifications->unique()->count();

        return response(compact('view', 'groupCount', 'specificationCount'));
    }

    public function destroy(SpecType $spectype)
    {
        $spectype->specifications()->detach();
        $spectype->delete();

        return response('success');
    }

    public function ajax_get(Request $request)
    {
        if ($request->term) {
            $spectypes = SpecType::detectLang()->where('name', 'like', '%' . $request->term . '%')->pluck('name')->toArray();

            return $spectypes;
        }
    }
}
