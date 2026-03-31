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
                                    <li class="breadcrumb-item">مدیریت</li>
                                    <li class="breadcrumb-item">محصولات</li>
                                    <li class="breadcrumb-item active">تغییر قیمت محصولات</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form class="ajax-form" action="{{ route('admin.prices.store') }}" data-redirect="{{ route('admin.products.index') }}" method="POST">
                @csrf
                <input type="hidden" name="brand_id" value="{{ $request->brand_id }}">
                <input type="hidden" name="type" value="{{ $request->type }}">
                <input type="hidden" name="amount_type" value="{{ $request->amount_type }}">
                <input type="hidden" name="amount" value="{{ $request->amount }}">
                <input type="hidden" name="discount" value="{{ $request->discount }}">


                <div class="content-body">

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">تایید تغییر قیمت</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                آیا میخواهید قیمت محصولات برند <strong class="d-inline-block">"{{ $brand->name }}"</strong>
                                @if ($request->type == 'discount' || $request->type == 'fake_discount')
                                    <span class="text-info">%{{ $request->discount }}</span>
                                @elseif ($request->amount_type == 'percentage')
                                    <span class="text-info">%{{ $request->amount }}</span>
                                @else
                                    <span class="text-info">{{ number_format($request->amount) }} تومان</span>
                                @endif

                                @if ($request->type == 'increase')
                                    <span class="text-success">افزایش</span> یابد؟
                                @elseif ($request->type == 'decrease')
                                    <span class="text-danger">کاهش</span> یابد؟
                                @elseif ($request->type == 'fake_discount')
                                <span class="text-danger">تخفیف غیر واقعی</span> داشته باشند؟
                                @else
                                    <span class="text-danger">تخفیف واقعی</span> داشته باشند؟
                                @endif

                                <div>
                                    <button type="submit" class="btn btn-danger mt-1">بله مورد تایید است</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($products->count())
                        <section class="card" id="main-card">
                            <div class="card-header">
                                <h4 class="card-title">لیست محصولات <small class="text-warning">(لطفا محصولات را برای تغییر قیمت انتخاب کنید)</small></h4>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><button id="select-all-prices" type="button" class="btn btn-outline-primary waves-effect waves-light">انتخاب همه</button></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @foreach ($products as $product)
                                        <div class="price-item my-1">
                                            <div class="row align-items-center">
                                                <div class="col-md-1 text-center">
                                                    <input class="product-checkbox" data-product="{{ $product->id }}" type="checkbox" name="products[]" value="{{ $product->id }}">
                                                </div>
                                                <div class="col-md-1 text-center">
                                                    <img class="post-thumb" src="{{ $product->imageUrl() }}" alt="image">
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="row">
                                                        <div class="col-12 pt-2 pb-1">
                                                            {{ $product->title }} <small>({{ $product->category->title ?? ''}})</small>
                                                            <a class="float-right" href="{{ Route::has('front.products.show') ? route('front.products.show', ['product' => $product]) : '' }}" target="_blank">
                                                                <i class="feather icon-external-link"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="prices-input-area">
                                                        <div class="row d-none d-md-flex">
                                                            <div class="col-4"></div>
                                                            <div class="col-2">
                                                                <span>قیمت قبلی:</span>
                                                            </div>
                                                            <div class="col-2">
                                                                <span>قیمت جدید:</span>
                                                            </div>
                                                            <div class="col-2">
                                                                <span>تخفیف قبلی:</span>
                                                            </div>
                                                            <div class="col-2">
                                                                <span>تخفیف جدید:</span>
                                                            </div>
                                                        </div>
                                                        <hr class="price-seperator">

                                                        @foreach ($product->prices()->where('stock', '>', 0)->get() as $price)
                                                            @php
                                                                $new_price = getNewPrice(request(), $price);
                                                            @endphp

                                                            <div class="row my-1">
                                                                <div class="col-md-4">
                                                                    <span>{{ $price->getAttributesValue() }}</span>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    @if ($price->salePrice() != $price->regularPrice())
                                                                        <del class="text-danger">{{ number_format($price->regularPrice()) }}</del><br>
                                                                    @endif
                                                                    <span class="text-danger">{{ number_format($price->salePrice()) }}</span>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    @if ($new_price['discount_price'] != $new_price['regular_price'])
                                                                        <del class="text-danger">{{ number_format($new_price['regular_price']) }}</del><br>
                                                                    @endif
                                                                    <span class="text-success">{{ number_format($new_price['discount_price']) }}</span>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    @if ($price->discount)
                                                                        <span class="text-danger">{{ $price->discount }}%</span>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-2">
                                                                    @if ($new_price['discount'])
                                                                        <span class="text-success">{{ $new_price['discount'] }}%</span>
                                                                    @endif
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

                        </section>
                    @else
                        <section class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="card-text">
                                        <p>چیزی برای نمایش وجود ندارد!</p>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif

                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .price-item.active {
            background-color: #f6f6f6
        }
    </style>
@endpush

@push('scripts')
    <script>
        $('.product-checkbox').on('change', function() {
            if ($(this).prop("checked")) {
                $(this).closest('.price-item').addClass('active');
            } else {
                $(this).closest('.price-item').removeClass('active');
            }
        });

        let selectAll = false;

        $('#select-all-prices').on('click', function() {

            if (selectAll) {
                $('.product-checkbox').prop("checked", false);
            } else {
                $('.product-checkbox').prop("checked", true);
            }

            $('.product-checkbox').trigger('change');

            selectAll = !selectAll;
        })
    </script>
@endpush
