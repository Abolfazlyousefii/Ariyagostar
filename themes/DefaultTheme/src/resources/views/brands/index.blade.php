@extends('front::layouts.master', ['title' => 'برند ها'])

@push('meta')

    @if(option('allow_indexing_brands') == "off")
        <meta name="robots" content="noindex, nofollow">
        <meta name="googlebot" content="noindex, nofollow">
        <meta name="bingbot" content="noindex, nofollow">

    @else
        <meta name="robots" content="index, follow"/>
        <meta name="googlebot" content="index, follow">
        <meta name="bingbot" content="index, follow">
    @endif
    <meta name="description" content="{{ option('info_short_description') }}">
    <meta name="keywords" content="{{ option('info_tags') }}">
    <link rel="canonical" href="{{ route('front.brands.index') }}" />
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
                                <span>برندها</span>
                            </nav>
                        </div>
                    </div>
                    @if ($brands->count())
                        <div class="">
                            <div class="row justify-content-center mb-4">
                                <div class="col-md-4">
                                    <input class="form-control" type="text" id="brand-search" placeholder="جستجوی برند">
                                </div>
                            </div>
                            <div id="brands" class="row">

                                @foreach ($brands as $brand)
                                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 px-1 single-brand-div">
                                        <a href="{{ route('front.brands.show', ['brand' => $brand]) }}">
                                            <div class="product-card mb-1 brands-index">
                                                <div class="product-card-body w-100">
                                                    <h5 class="product-title">
                                                        {{ $brand->name }}
                                                    </h5>
                                                </div>

                                            </div>
                                        </a>
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

@push('scripts')
    <script src="{{ theme_asset('js/pages/brands/index.js') }}?v=1"></script>
@endpush
