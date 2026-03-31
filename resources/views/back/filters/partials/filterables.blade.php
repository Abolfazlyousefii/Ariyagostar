@foreach ($filter->related()->orderBy('ordering')->get() as $item)
    @switch($item->filterable_type)
        @case('App\Models\Specification')
            <tr id="specification-spec-tr-{{ $item->filterable->id }}">
                <td class="text-center draggable-handler">
                    <div class="fonticon-wrap"><i class="feather icon-move"></i></div>
                </td>
                <td class="text-center"><span>{{ $item->filterable->name }}</span> <small class="text-warning">( مشخصات )</small></td>
                <td class="text-center">
                    <div class="custom-control custom-switch custom-control-inline m-0">
                        <input type="checkbox" class="custom-control-input" id="filters[{{ $loop->index }}][active]" {{ $item->active ? 'checked' : '' }} name="filters[{{ $loop->index }}][active]">
                        <label class="custom-control-label" for="filters[{{ $loop->index }}][active]">
                        </label>
                    </div>
                </td>
                <td class="text-center">
                    <div>
                        <input type="text" class="form-control" placeholder="جداکننده" name="filters[{{ $loop->index }}][separator]" value="{{ $item->separator }}">
                    </div>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger waves-effect waves-light remove-filter">حذف</button>
                </td>
                <input type="hidden" name="filters[{{ $loop->index }}][type]" value="specification">
                <input type="hidden" name="filters[{{ $loop->index }}][id]" value="{{ $item->filterable->id }}">
            </tr>
            @break
        @case('App\Models\StaticFilter')
            <tr id="static_filter-spec-tr-{{ $item->filterable->id }}">
                <td class="text-center draggable-handler">
                    <div class="fonticon-wrap"><i class="feather icon-move"></i></div>
                </td>
                <td class="text-center"><span>{{ $item->filterable->title }}</span> <small class="text-warning">( فیلتر ثابت )</small></td>
                <td class="text-center">
                    <div class="custom-control custom-switch custom-control-inline m-0">
                        <input type="checkbox" class="custom-control-input" id="filters[{{ $loop->index }}][active]" {{ $item->active ? 'checked' : '' }} name="filters[{{ $loop->index }}][active]">
                        <label class="custom-control-label" for="filters[{{ $loop->index }}][active]">
                        </label>
                    </div>
                </td>
                <td class="text-center">

                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger waves-effect waves-light remove-filter">حذف</button>
                </td>
                <input type="hidden" name="filters[{{ $loop->index }}][type]" value="static_filter">
                <input type="hidden" name="filters[{{ $loop->index }}][id]" value="{{ $item->filterable->id }}">
            </tr>
            @break
        @case('App\Models\AttributeGroup')
            <tr id="attributeGroup-spec-tr-{{ $item->filterable->id }}">
                <td class="text-center draggable-handler">
                    <div class="fonticon-wrap"><i class="feather icon-move"></i></div>
                </td>
                <td class="text-center"><span>{{ $item->filterable->name }}</span> <small class="text-warning">( گروه ویژگی )</small></td>
                <td class="text-center">
                    <div class="custom-control custom-switch custom-control-inline m-0">
                        <input type="checkbox" class="custom-control-input" id="filters[{{ $loop->index }}][active]" {{ $item->active ? 'checked' : '' }} name="filters[{{ $loop->index }}][active]">
                        <label class="custom-control-label" for="filters[{{ $loop->index }}][active]">
                        </label>
                    </div>
                </td>
                <td class="text-center">

                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger waves-effect waves-light remove-filter">حذف</button>
                </td>
                <input type="hidden" name="filters[{{ $loop->index }}][type]" value="attributeGroup">
                <input type="hidden" name="filters[{{ $loop->index }}][id]" value="{{ $item->filterable->id }}">
            </tr>
            @break


    @endswitch
@endforeach
