@extends('front::layouts.master', ['title' => $brand->name])

@push('meta')

    <meta property="og:title" content="{{ $brand->name }}" />
    <link rel="canonical" href="{{ route('front.brands.show', ['brand' => $brand]) }}" />
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
                                <a href="/">خانه</a>
                                <span>{{ $brand->name }}</span>
                            </nav>
                        </div>
                    </div>
                    @if($products->count())
                        <div class="dt-sl dt-sn px-0 search-amazing-tab">
                            <div class="row mb-3 mx-0 px-res-0">
                            @foreach($products as $product)

                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 px-10 mb-1 px-res-0">
                                        @include('front::products.partials.product-card', ['product' => $product])
                                    </div>

                                    @endforeach
                            </div>

                            {{ $products->links('front::components.paginate') }}
                        </div>
                    @else
                        @include('front::partials.empty')
                    @endif
                </div>
                <!-- End Content -->
            </div>

            @if ($brand->description)
                <div class="row mt-2">
                    <div class="dt-sl dt-sn search-amazing-tab mb-3 mx-3" >
                        <div class="row">
                            <div class="col-md-12 p-md-4">
                                {!! $brand->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </main>
    <!-- End main-content -->

@endsection
