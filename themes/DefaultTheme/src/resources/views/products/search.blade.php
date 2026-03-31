@extends('front::layouts.master', ['title' => trans('front::messages.products.looking-for') . ' ' . request('q')])

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
                            <span>{{ trans('front::messages.products.looking-for') . ' ' . request('q') }}</span>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12">
                    @if ($products->count())
                        <div class="dt-sl dt-sn px-0 search-amazing-tab">

                            <div class="row mb-3 mx-0 px-res-0">
                                @foreach ($products as $product)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 px-10 mb-1 px-res-0 category-product-div">
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
            </div>

        </div>
    </main>
    <!-- End main-content -->
@endsection
