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
        <meta property="og:url" content="{{ route('front.products.category', ['category' => $category]) }}" />
        <meta name="description" content="{{ $category->meta_description ?: $category->description }}">
        <meta name="keywords" content="{{ $category->getTags }}">
        <link rel="canonical" href="{{ route('front.products.category', ['category' => $category]) }}" />
    @endpush

    @section('content')

        <!-- Start main-content -->
        <main class="main-content dt-sl mt-4 mb-3">
            <div class="container main-container">

                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 search-card-res">
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

                        @if ($category->description)

                            <div class="dt-sl dt-sn search-amazing-tab mb-2" >
                                <div class="row">

                                    <div class="col-md-12 p-md-5 category-background" style="background-image: url({{ asset($category->background_image) }});">
                                        {!! $category->description !!}
                                    </div>
                                </div>
                            </div>

                        @endif

                        @if($category->getCategoriesCount())
                            <div class="dt-sl dt-sn px-0 search-amazing-tab">
                                <div class="row mb-3 mx-0 px-res-0">


                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 px-10 mb-1 px-res-0">
                                        <div class="product-card mb-2 mx-res-0 category-index">
                                            <div class="product-card-body">
                                                <h5 class="product-title">
                                                    <a href="{{ route('front.products.category-products', ['category' => $category]) }}">{{ trans('front::messages.products.all-products') }}</a>
                                                </h5>
                                            </div>
                                            <a class="product-thumb" href="{{ route('front.products.category-products', ['category' => $category]) }}">
                                                <img data-src="{{ $category->image ?: asset('/no-image-product.png') }}" alt="{{ $category->title }}">
                                            </a>

                                            <a href="{{ route('front.products.category-products', ['category' => $category]) }}" class="more-cat">{{ trans('front::messages.products.view-all-products') }}</a>
                                        </div>
                                    </div>

                                    @foreach($category->getCategories() as $cat)
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 px-10 mb-1 px-res-0">
                                            <div class="product-card mb-2 mx-res-0 category-index">
                                                <div class="product-card-body">
                                                    <h5 class="product-title">
                                                        <a href="{{ route('front.products.category', ['category' => $cat]) }}">{{ $cat->title }}</a>
                                                    </h5>
                                                </div>
                                                <a class="product-thumb" href="{{ route('front.products.category', ['category' => $cat]) }}">
                                                    <img data-src="{{ $cat->image ?: asset('/no-image-product.png') }}" alt="{{ $cat->title }}">
                                                </a>

                                                <a href="{{ route('front.products.category', ['category' => $cat]) }}" class="more-cat">{{ trans('front::messages.products.view-products') }}</a>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        @else
                            @include('front::partials.empty')
                        @endif
                    </div>
                    <!-- End Content -->
                </div>

            </div>
        </main>
        <!-- End main-content -->


    @endsection
