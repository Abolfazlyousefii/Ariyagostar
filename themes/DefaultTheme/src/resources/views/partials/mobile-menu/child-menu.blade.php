@if($menu->menus->isEmpty())

    @switch($menu->type)
        @case('static')
        @include('front::partials.mobile-menu.static-menus', ['menu' => $menu])
        @break

        @case('category')

        @include('front::partials.mobile-menu.child-category', ['category' => $menu->category])
        @break

        @default

        <li>
            <a href="{{ $menu->link }}">{{ $menu->title }}</a>
        </li>

    @endswitch
@else

    @switch($menu->type)
        @case('category')
        <li class="sub-menu">
            <a href="{{ $menu->category->link }}">{{ $menu->category->title }}</a>
            <ul>

                @if($menu->category->getCategoriesCount())
                    @foreach ($menu->category->getCategories() as $childCategory)
                        @include('front::partials.mobile-menu.child-category', ['category' => $childCategory])
                    @endforeach
                @endif

                @foreach ($menu->childrenmenus as $childMenu)
                    @include('front::partials.mobile-menu.child-menu', ['menu' => $childMenu])
                @endforeach

            </ul>
        </li>

        @break

        @default

        <li class="sub-menu">
            <a href="{{ $menu->link }}">{{ $menu->title }}</a>
            <ul>
                @foreach ($menu->childrenmenus as $childMenu)
                    @include('front::partials.mobile-menu.child-menu', ['menu' => $childMenu])
                @endforeach
            </ul>
        </li>

    @endswitch
@endif
