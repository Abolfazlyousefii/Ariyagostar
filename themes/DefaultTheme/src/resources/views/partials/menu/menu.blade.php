<nav class="main-menu dt-sl">
    <ul class="list float-right hidden-md">
        @foreach($menus as $menu)
            @include('front::partials.menu.child-menu')
        @endforeach

    </ul>
    <ul class="nav float-left">
        @include('front::partials.cart')
    </ul>

    @include('front::partials.mobile-menu.menu')
</nav>
