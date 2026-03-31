
<li class="list-item list-item-has-children position-static">
    <a class="nav-link" href="{{ $menu->link }}">{{ $menu->title }}</a>

    <ul class="f-menu sub-menu nav">

        @foreach($menu->childrenmenus as $childMenu)

            @switch($childMenu->type)
                @case('category')
                    {{-- level 1 --}}
                    <li class="{{ $loop->first ? 'active' : '' }}">
                        <a class="master-menu" href="{{ $childMenu->category->link }}">{{ $childMenu->title ?: $childMenu->category->title }}</a>
                        <div class="megadrop row">
                            @if ($childMenu->category->getCategoriesCount() && $childMenu->children)

                                {{-- level 2 --}}
                                @foreach ($childMenu->category->getCategories() as $childCategory)
                                    <a href="{{ $childCategory->link }}"><div class="h5">{{ $childCategory->title }}</div></a>

                                    {{-- level 3 --}}
                                    @foreach ($childCategory->getCategories() as $child2)
                                        <a href="{{ $child2->link }}"><div class="h6">{{ $child2->title }}</div></a>
                                    @endforeach

                                @endforeach

                            @endif

                            {{-- level 2 --}}
                            @include('front::partials.megamenu.level2')
                        </div>
                    </li>
                    @break

                @case('normal')

                    <li class="{{ $loop->first ? 'active' : '' }}">
                        <a class="master-menu" href="{{ $childMenu->link }}">{{ $childMenu->title }}</a>
                        <div class="megadrop row">
                            @include('front::partials.megamenu.level2')
                        </div>
                    </li>
                    @break
                @default

            @endswitch

        @endforeach

    </ul>
</li>
