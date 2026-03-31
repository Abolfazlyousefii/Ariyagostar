<a href="{{ $childMenu2->category->link }}"><div class="h5">{{ $childMenu2->title ?: $childMenu2->category->title }}</div></a>

@if (!$childMenu2->category->categories->isEmpty() && $childMenu2->children)

    {{-- level 3 --}}
    @foreach ($childMenu2->category->categories as $childCategory2)
        <a href="{{ $childCategory2->link }}"><div class="h6">{{ $childCategory2->title }}</div></a>
    @endforeach

@endif

{{-- level 3 --}}
@foreach ($childMenu2->childrenmenus as $child3)
    <a href="{{ $child3->link }}"><div class="h6">{{ $child3->title }}</div></a>
@endforeach
