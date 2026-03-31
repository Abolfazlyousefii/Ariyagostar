<li id="{{ $category->id }}">{{ $category->title }}

    @if (! $category->categories->isEmpty())
        <ul>
            @foreach ($category->categories as $childCategory)
                @include('back.products.partials.categories-tree', ['category' => $childCategory])
            @endforeach
        </ul>
    @endif

</li>
