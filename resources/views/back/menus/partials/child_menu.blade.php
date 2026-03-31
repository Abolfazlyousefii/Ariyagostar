@if($child_menu->menus->isEmpty())
    @if($child_menu->type == 'static')
        <li data-category-type="{{ $child_menu->type }}" class="dd-item dd-static" data-static="true" data-id="{{ $child_menu->id }}">

            <div class="dd-handle"><span class="menu-title">{{  $child_menu->full_title  }}</span>
                <a data-menu="{{ $child_menu->id }}" class="float-right delete-menu dd-nodrag" href="javascript:void(0)"><i class="fa fa-trash text-danger px-1"></i>حذف</a>
                <a data-menu="{{ $child_menu->id }}" class="float-right edit-menu dd-nodrag" href="javascript:void(0)"><i class="fa fa-pencil text-info px-1"></i>ویرایش</a>
            </div>
        </li>
    @else
        <li data-category-type="{{ $child_menu->type }}" class="dd-item" data-id="{{ $child_menu->id }}">

            <div class="dd-handle"><span class="menu-title">{{  $child_menu->full_title  }}</span>
                <a data-menu="{{ $child_menu->id }}" class="float-right delete-menu dd-nodrag" href="javascript:void(0)"><i class="fa fa-trash text-danger px-1"></i>حذف</a>
                <a data-menu="{{ $child_menu->id }}" class="float-right edit-menu dd-nodrag" href="javascript:void(0)"><i class="fa fa-pencil text-info px-1"></i>ویرایش</a>
            </div>
        </li>
    @endif

@else
    <li data-category-type="{{ $child_menu->type }}" class="dd-item" data-id="{{ $child_menu->id }}">

        <div class="dd-handle"><span class="menu-title">{{ $child_menu->full_title }}</span>
            <a data-menu="{{ $child_menu->id }}" class="float-right delete-menu dd-nodrag" href="javascript:void(0)"><i class="fa fa-trash text-danger px-1"></i>حذف</a>
            <a data-menu="{{ $child_menu->id }}" class="float-right edit-menu dd-nodrag" href="javascript:void(0)"><i class="fa fa-pencil text-info px-1"></i>ویرایش</a>
        </div>
        <ol class="dd-list">
            @foreach ($child_menu->childrenMenus as $childMenu)
                @include('back.menus.partials.child_menu', ['child_menu' => $childMenu])
            @endforeach
        </ol>
    </li>
@endif
