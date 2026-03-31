@switch($menu->static_type)
    @case('products')
        @if($productcats->count())
            <li class="sub-menu">
                <a href="{{ route('front.products.index') }}">{{ $menu->title }}</a>
                <ul>
                    @foreach($productcats as $category)
                        @include('front::partials.mobile-menu.child-category')
                    @endforeach
                </ul>
            </li>
        @endif
        
        @break
        
    @case('posts')
        @if($postcats->count())
            <li class="sub-menu">
                <a href="{{ route('front.posts.index') }}">{{ $menu->title }}</a>
                <ul>
                    @foreach($postcats as $category)
                        @include('front::partials.mobile-menu.child-category')
                    @endforeach
                </ul>
            </li>
        @endif
        
        @break

@endswitch

