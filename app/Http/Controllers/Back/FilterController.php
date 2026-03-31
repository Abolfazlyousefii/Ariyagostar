<?php

namespace App\Http\Controllers\Back;

use App\Models\AttributeGroup;
use App\Models\Filter;
use App\Models\Filterable;
use App\Http\Controllers\Controller;
use App\Models\Specification;
use App\Models\StaticFilter;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Filter::class, 'filter');
    }

    public function index()
    {
        $filters = Filter::latest()->paginate(10);

        return view('back.filters.index', compact('filters'));
    }

    public function create()
    {
        $static_filters        = StaticFilter::orderBy('ordering')->get();
        $specifications        = Specification::get();
        $attributeGroups       = AttributeGroup::orderBy('ordering')->get();

        return view('back.filters.create', compact(
            'static_filters',
            'specifications',
            'attributeGroups'
        ));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'          => 'required|unique:filters,title',
            'filters'        => 'required|array',
            'filters.*.type' => 'required|in:static_filter,attributeGroup,specification',
            'filters.*.id'   => 'required|numeric',
        ]);

        $filter = Filter::create([
            'title' => $request->title,
        ]);

        $ordering = 1;

        foreach ($request->filters as $item) {
            $this->add_filterable($filter, $item, $ordering++);
        }

        toastr()->success('فیلتر با موفقیت ایجاد شد.');

        return response("success");
    }

    public function edit(Filter $filter)
    {
        $static_filters        = StaticFilter::orderBy('ordering')->get();
        $specifications        = Specification::get();
        $attributeGroups       = AttributeGroup::orderBy('ordering')->get();

        return view('back.filters.edit', compact(
            'static_filters',
            'specifications',
            'attributeGroups',
            'filter'
        ));
    }

    public function update(Filter $filter, Request $request)
    {
        $this->validate($request, [
            'title'          => 'required|unique:filters,title,' . $filter->id,
            'filters'        => 'required|array',
            'filters.*.type' => 'required|in:static_filter,attributeGroup,specification',
            'filters.*.id'   => 'required|numeric',
        ]);

        $filter->update([
            'title' => $request->title,
        ]);

        $ordering = 1;
        $filterables = [];

        foreach ($request->filters as $item) {
            $filterables[] = $this->add_filterable($filter, $item, $ordering++);
        }

        $filter->related()->whereNotIn('id', $filterables)->delete();

        toastr()->success('فیلتر با موفقیت ویرایش شد.');

        return response("success");
    }

    public function destroy(Filter $filter)
    {
        $filter->delete();

        return response('success');
    }

    private function add_filterable($filter, $item, $ordering)
    {
        switch ($item['type']) {
            case 'static_filter': {
                    $filterable = StaticFilter::find($item['id']);

                    if ($filterable) {
                        $inserted_filterable = Filterable::updateOrCreate(
                            [
                                'filter_id'       => $filter->id,
                                'filterable_id'   => $filterable->id,
                                'filterable_type' => StaticFilter::class,
                            ],
                            [
                                'ordering' => $ordering,
                                'active'   => isset($item['active'])
                            ]
                        );
                    }
                    break;
                }

            case 'attributeGroup': {
                    $filterable = AttributeGroup::find($item['id']);

                    if ($filterable) {
                        $inserted_filterable = Filterable::updateOrCreate(
                            [
                                'filter_id'       => $filter->id,
                                'filterable_id'   => $filterable->id,
                                'filterable_type' => AttributeGroup::class,
                            ],
                            [
                                'ordering' => $ordering,
                                'active'   => isset($item['active'])
                            ]
                        );
                    }
                    break;
                }

            case 'specification': {
                    $filterable = Specification::find($item['id']);

                    if ($filterable) {
                        $inserted_filterable = Filterable::updateOrCreate(
                            [
                                'filter_id'       => $filter->id,
                                'filterable_id'   => $filterable->id,
                                'filterable_type' => Specification::class,
                            ],
                            [
                                'ordering'    => $ordering,
                                'active'      => isset($item['active']),
                                'separator'   => isset($item['separator']) ? $item['separator'] : null,
                            ]
                        );
                    }
                    break;
                }
        }

        return $inserted_filterable->id;
    }
}
