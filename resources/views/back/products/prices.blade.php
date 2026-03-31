@extends('back.layouts.master')

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb no-border">
                                    <li class="breadcrumb-item">مدیریت
                                    </li>
                                    <li class="breadcrumb-item">مدیریت محصولات
                                    </li>
                                    <li class="breadcrumb-item active">قیمت ها
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                <!-- filter start -->
                @include('back.products.partials.filters', ['filter_action' => route('admin.product.prices.index')])
                <!-- filter end -->

                @if ($products->count())
                    <form id="prices-update-form" action="{{ route('admin.product.prices.update') }}">
                        @method('put')
                        <section class="card" id="main-card">
                            <div class="card-header">
                                <h4 class="card-title">قیمت ها</h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li>
                                            <button type="button" class="btn btn-outline-primary waves-effect waves-light save-price-changes"><i class="fa fa-save"></i> ذخیره تغییرات</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @foreach ($products as $product)
                                        <div class="price-item">
                                            <div class="row align-items-center">
                                                <div class="col-md-1 text-center">
                                                    <img class="post-thumb" src="{{ $product->imageUrl() }}" alt="image">
                                                </div>
                                                <div class="col-md-11">
                                                    <div class="row">
                                                        <div class="col-12 pt-2 pb-1">
                                                            {{ $product->title }}
                                                            <a class="float-right" href="{{ Route::has('front.products.show') ? route('front.products.show', ['product' => $product]) : '' }}" target="_blank">
                                                                <i class="feather icon-external-link"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="prices-input-area">
                                                        <div class="row d-none d-md-flex">
                                                            <div class="col-5"></div>
                                                            <div class="col-3">
                                                                <span>قیمت :</span>
                                                            </div>
                                                            <div class="col-2">
                                                                <span>تعداد :</span>
                                                            </div>
                                                            <div class="col-2 text-center">
                                                                <span>آخرین تغییر</span>
                                                            </div>
                                                        </div>
                                                        <hr class="price-seperator">
                                                        @foreach ($product->prices as $price)
                                                            <div class="row my-1">
                                                                <div class="col-md-5">
                                                                    <span>{{ $price->getAttributesName() }}</span>
                                                                </div>
                                                                <div class="col-md-3 text-center">
                                                                    <input class="form-control form-control-sm ltr text-center amount-input" name="products[{{ $product->id }}][prices][{{ $price->id }}][price]" value="{{ $price->price() }}" data-unit="{{ $price->product->currency ? $price->product->currency->title : 'تومان' }}" type="number">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input class="form-control form-control-sm ltr text-center" name="products[{{ $product->id }}][prices][{{ $price->id }}][stock]" value="{{ $price->stock }}" type="number" {{ $price->product->isDownload() ? 'readonly' : '' }}>
                                                                </div>
                                                                <div class="col-md-2 text-center">
                                                                    <span class="text-info">
                                                                        {{ jdate($price->updated_at)->ago() }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <div class="heading-elements">
                                    <ul class="list-inline d-block mb-0">
                                        <li>
                                            <button type="button" class="btn btn-outline-primary waves-effect waves-light save-price-changes">
                                                <i class="fa fa-save"></i> ذخیره تغییرات
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </section>
                    </form>
                @else
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">قیمت ها</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="card-text">
                                    <p>چیزی برای نمایش وجود ندارد!</p>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
                {{ $products->appends(request()->all())->links() }}


            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/products/filters.js') }}?v=2"></script>
    <script src="{{ asset('back/assets/js/pages/products/prices.js') }}"></script>
@endpush
