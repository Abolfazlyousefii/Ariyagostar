@switch($menu->static_type)
    @case('products')
        @if($productcats->count())
            <li class="list-item list-item-has-children position-static">
                <a class="nav-link" href="{{ route('front.products.index') }}">{{ $menu->title }}</a>

                <ul class="f-menu sub-menu nav products-mega-menu" role="menu" aria-label="{{ $menu->title }}">
                    @foreach ($productcats as $category)
                        <li class="{{ $loop->first ? 'active' : '' }}" role="none">
                            <a class="master-menu" role="menuitem" href="{{ $category->link }}">{{ $category->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endif

        @break

    @case('posts')
        @if($postcats->count())

            <!-- mega menu 5 column -->
            <li class="list-item list-item-has-children menu-col-1">
                <a class="nav-link" href="{{ route('front.blog.index') }}">{{ $menu->title }}</a>
                <ul class="sub-menu nav">
                    @foreach($postcats as $category)
                        @include('front::partials.menu.child-category', ['category' => $category])
                    @endforeach
                </ul>
            </li>
        @endif

        @break

@endswitch
