

@if($menu->menus->isEmpty())

    @switch($menu->type)
        @case('static')
            @include('front::partials.menu.static-menus', ['menu' => $menu])
            @break

        @case('category')

            @include('front::partials.menu.child-menucategory', ['menu' => $menu])
            @break

        @case('normal')
        @case('megamenu')

            <li class="list-item">
                <a class="nav-link" href="{{ $menu->link }}">{{ $menu->title }}</a>
            </li>

    @endswitch

@else

    @switch($menu->type)
        @case('category')

            <li class="list-item list-item-has-children menu-col-1">
                <a class="nav-link" href="{{ $menu->category->link }}">{{ $menu->category->title }}</a>
                <ul class="sub-menu nav">
                    @if(!$menu->category->categories->isEmpty())
                        @foreach ($menu->category->categories as $childCategory)
                            @include('front::partials.menu.child-category', ['category' => $childCategory])
                        @endforeach
                    @endif

                    @foreach ($menu->childrenmenus as $childMenu)
                        @include('front::partials.menu.child-menu', ['menu' => $childMenu])
                    @endforeach
                </ul>
            </li>
            @break

        @case('megamenu')

            @include('front::partials.menu.megamenu', ['menu' => $menu])

            @break

        @default

            <li class="list-item list-item-has-children menu-col-1">
                <a class="nav-link" href="{{ $menu->link }}">{{ $menu->title }}</a>
                <ul class="sub-menu nav">
                    @foreach ($menu->childrenmenus as $childMenu)
                        @include('front::partials.menu.child-menu', ['menu' => $childMenu])
                    @endforeach
                </ul>
            </li>

    @endswitch

@endif
