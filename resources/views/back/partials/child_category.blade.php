<li class="dd-item" data-id="{{ $child_category->id }}">
    <div class="dd-handle">
        <span class="category-title">{{ $child_category->title }}</span>
        <a data-category="{{ $child_category->slug }}" class="float-right delete-category dd-nodrag" href="javascript:void(0)" data-toggle="modal" data-target="#modal-delete">
            <i class="fa fa-trash text-danger px-1"></i>حذف
        </a>
        <a data-category="{{ $child_category->slug }}" class="float-right edit-category dd-nodrag" href="javascript:void(0)">
            <i class="fa fa-pencil text-info px-1"></i>ویرایش
        </a>
    </div>
    @if ($child_category->childrenCategories->isNotEmpty())
        <ol class="dd-list">
            @foreach ($child_category->childrenCategories as $child)
                @include('back.partials.child_category', ['child_category' => $child])
            @endforeach
        </ol>
    @endif
</li>
