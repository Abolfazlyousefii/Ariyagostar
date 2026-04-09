@extends('front::layouts.master', ['title' => $category->title])

@push('meta')
    @if(option('allow_indexing_categories') == "off")
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="bingbot" content="noindex, nofollow">

    @else
    <meta name="robots" content="index, follow"/>
    <meta name="googlebot" content="index, follow">
    <meta name="bingbot" content="index, follow">
    @endif
    <meta property="og:title" content="{{ $category->meta_title ?: $category->title }}" />
    <meta property="og:url" content="{{ request()->url() }}" />
    <meta name="description" content="{{ $category->meta_description ?: $category->description }}">
    <meta name="keywords" content="{{ $category->getTags }}">
    <link rel="canonical" href="{{ request()->url() }}" />
@endpush

@push('befor-styles')
    <link rel="stylesheet" href="{{ theme_asset('css/vendor/nouislider.min.css') }}">
@endpush

@php
    $has_filter = $category->getFilter();
@endphp

@section('content')

    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container main-container">

            <div class="row">
                <!-- Start Content -->
                <div class="title-breadcrumb-special dt-sl mb-3">
                    <div class="breadcrumb dt-sl">
                        <nav>
                            <a href="/">{{ trans('front::messages.products.home') }}</a>
                            <a href="{{ route('front.products.index') }}">{{ trans('front::messages.products.products') }}</a>

                            @foreach ($category->parents() as $parent)
                                <a href="{{ route('front.products.category', ['category' => $parent]) }}">{{ $parent->title }}</a>
                            @endforeach
                            <span>{{ $category->title }}</span>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                @if ($has_filter)
                    @include('front::products.partials.category-filters')
                @endif

                <div id="category-products-div" data-action="{{ route('front.products.category-products', ['category' => $category]) }}" class="{{ $category->getFilter() ? 'col-lg-9' : 'col-lg-12' }} col-md-12 col-sm-12">
                    @if($products->count())
                        <div class="dt-sl dt-sn px-0 search-amazing-tab">

                            <div class="row">
                                <div class="products-list-sort-type ah-tab-wrapper dt-sl">
                                    <div class="ah-tab dt-sl">
                                        <a class="ah-tab-item" data-sort="latest" {{ request('sort_type') == 'latest' || !request('sort_type') ? 'data-ah-tab-active=true' : '' }} href="#">{{ trans('front::messages.categories.the-newest') }}</a>
                                        <a class="ah-tab-item" data-sort="view" {{ request('sort_type') == 'view' ? 'data-ah-tab-active=true' : '' }} href="#">{{ trans('front::messages.categories.the-most-visited') }}</a>
                                        <a class="ah-tab-item" data-sort="sale" {{ request('sort_type') == 'sale' ? 'data-ah-tab-active=true' : '' }} href="#">{{ trans('front::messages.categories.bestselling') }}</a>
                                        <a class="ah-tab-item" data-sort="cheapest" {{ request('sort_type') == 'cheapest' ? 'data-ah-tab-active=true' : '' }} href="#">{{ trans('front::messages.categories.cheapest') }}</a>
                                        <a class="ah-tab-item" data-sort="expensivest" {{ request('sort_type') == 'expensivest' ? 'data-ah-tab-active=true' : '' }} href="#">{{ trans('front::messages.categories.most-expensive') }}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 mx-0 px-res-0">
                                @foreach($products as $product)

                                    <div class="col-md-4 col-sm-6 col-12 px-10 mb-1 px-res-0 category-product-div product-grid-item">
                                        @include('front::products.partials.product-card', ['product' => $product])
                                    </div>

                                @endforeach
                            </div>

                            {{ $products->appends(request()->all())->links('front::components.paginate') }}
                        </div>
                    @else
                        @include('front::partials.empty')
                    @endif
                </div>
            </div>

            @if ($category->description)
                <div class="row mt-2">
                    <div class="dt-sl dt-sn search-amazing-tab mb-3 mx-3" >
                        <div class="row">

                            <div class="col-md-12 p-md-5 category-background" style="background-image: url({{ asset($category->background_image) }});">
                                {!! $category->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </main>
    <!-- End main-content -->
@endsection

@push('scripts')

    <script>
        var selected_min_price = {{ request('min_price') ?: $min_price }};
        var selected_max_price = {{ request('max_price') ?: $max_price }};
        var products_min_price = {{ $min_price }};
        var products_max_price = {{ $max_price }};
    </script>

    <script src="{{ theme_asset('js/pages/products/category.js') }}?v=6"></script>
    <script src="{{ theme_asset('js/vendor/nouislider.min.js') }}"></script>
    <script src="{{ theme_asset('js/vendor/wNumb.js') }}"></script>
    <script src="{{ theme_asset('js/vendor/ResizeSensor.min.js') }}"></script>
@endpush
