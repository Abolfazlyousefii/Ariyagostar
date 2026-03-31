@foreach ($childMenu->childrenmenus as $childMenu2)

    @switch($childMenu2->type)
        @case('category')

            @include('front::partials.megamenu.category')

            @break
        @case('normal')
            <a href="{{ $childMenu2->link }}"><div class="h5">{{ $childMenu2->title }}</div></a>

            {{-- level 3 --}}
            @foreach ($childMenu2->childrenmenus as $child3)

                @switch($child3->type)
                    @case('category')
                        <a href="{{ $child3->category->link }}"><div class="h6">{{ $child3->title ?: $child3->category->title }}</div></a>

                        @break
                    @case('normal')
                        <a href="{{ $child3->link }}"><div class="h6">{{ $child3->title }}</div></a>

                        @break
                    @default

                @endswitch

            @endforeach


            @break
        @default

    @endswitch

@endforeach
