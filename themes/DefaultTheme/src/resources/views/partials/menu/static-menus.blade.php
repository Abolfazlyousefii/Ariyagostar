@switch($menu->static_type)
    @case('products')
        @if($productcats->count())
            <li class="list-item list-item-has-children position-static">
                <a class="nav-link" href="{{ route('front.products.index') }}">{{ $menu->title }}</a>

                <ul class="f-menu sub-menu nav">
                    @foreach ($productcats as $category)
                        <li class="{{ $loop->first ? 'active' : '' }}">
                            <a class="master-menu" href="{{ $category->link }}">{{ $category->title }}</a>
                            <div class="megadrop row">
                                @if ($category->getCategoriesCount())

                                    @foreach ($category->getCategories() as $childCategory)
                                        <a href="{{ $childCategory->link }}"><div class="h5">{{ $childCategory->title }}</div></a>

                                        @if ($childCategory->getCategoriesCount())

                                            @foreach ($childCategory->getCategories() as $child2)
                                                <a href="{{ $child2->link }}"><div class="h6">{{ $child2->title }}</div></a>
                                            @endforeach

                                        @endif
                                    @endforeach

                                @endif
                            </div>
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
                <a class="nav-link" href="{{ route('front.posts.index') }}">{{ $menu->title }}</a>
                <ul class="sub-menu nav">
                    @foreach($postcats as $category)
                        @include('front::partials.menu.child-category', ['category' => $category])
                    @endforeach
                </ul>
            </li>
        @endif

        @break

@endswitch
