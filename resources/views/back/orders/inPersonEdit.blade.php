@extends('back.layouts.master')

@push('styles')
    <style>
        .swal2-popup {
            width: 23em !important;
        }
    </style>
@endpush

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
                                    <li class="breadcrumb-item">سفارشات</li>
                                    <li class="breadcrumb-item active">ویرایش سفارش حضوری</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <h4 class="card-title">ویرایش سفارش حضوری</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" id="order-create-form" action="{{ route('admin.orders.inPersonUpdate', ['order' => $order]) }}" method="post">
                                @csrf
                                @method('put')

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>شماره موبایل <small>(نام کاربری)</small></label>
                                                <input type="text" class="form-control" name="mobile" value="{{ $order->mobile }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>نام و نام خانوادگی</label>
                                                <input type="text" class="form-control" name="name" value="{{ $order->name }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12" id="order-products-list">
                                    @foreach ($order->items as $item)
                                        <div class="row order-single-product" data-selected-price="{{ $item->price_id }}">
                                            <div class="col-md-1" style="padding-top: 33px;">
                                                <img class="w-100" src="{{ $item->product->imageUrl() }}" alt="{{ $item->title }}">
                                            </div>
                                            <div class="col-md-3 mt-1">
                                                <div class="mb-1">
                                                    <strong>{{ $item->title }}</strong>
                                                </div>

                                                <div class="mb-1">
                                                    <select class="form-control price-select">
                                                        @foreach ($item->product->prices as $price)
                                                            <option value="{{ $price->id }}" data-price='@json(new \App\Http\Resources\Api\V1\Price\PriceResource($price))' {{ $price->id == $item->price_id ? 'selected' : '' }}>
                                                                {{ $price->getAttributesName() }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <strong class="text-success"><span class="sale-price">{{ number_format($item->real_price) }}</span> تومان</strong>

                                                <del class="text-danger regular-price-container {{ $item->discount ? '' : 'd-none' }}"><span class="regular-price">{{ number_format($item->price) }}</span> تومان</del>

                                                <input class="selected-price" name="products[{{ $loop->index }}][price_id]" type="hidden" value="{{ $item->price_id }}">
                                                <input name="products[{{ $loop->index }}][id]" type="hidden" value="{{ $item->product_id }}">
                                            </div>
                                            <div class="col-md-2" style="padding-top: 18px;">
                                                <div class="form-group">
                                                    <label for="">قیمت</label>
                                                    <input type="number" name="products[{{ $loop->index }}][price]" class="form-control product-price amount-input ltr" value="{{ $item->real_price }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2" style="padding-top: 18px;">
                                                <div class="form-group">
                                                    <label for="">تخفیف (تومان)</label>
                                                    <input type="number" name="products[{{ $loop->index }}][discount]" class="form-control ltr product-discount amount-input" value="{{ $item->discount }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2" style="padding-top: 18px;">
                                                <div class="form-group">
                                                    <label for="">تعداد</label>
                                                    <input type="number" data-prev-id="{{ $item->price_id }}" data-prev-quantity="{{ $item->quantity }}" name="products[{{ $loop->index }}][quantity]" class="form-control product-quantity ltr" value="{{ $item->quantity }}" max="{{ $item->quantity + ($item->get_price->stock ?? 0)}}" min="1">
                                                </div>
                                            </div>
                                            <div class="col-md-2" style="padding-top: 38px;">
                                                <button type="button" class="btn btn-outline-danger delete-product-btn" style="margin-top: 8px;"><i class="feather icon-trash"></i></button>
                                            </div>
                                            <hr class="w-100">
                                        </div>
                                    @endforeach
                                </div>

                                <div class="col-md-6 text-center mt-3 mb-4">
                                    <input id="add-product-to-order" data-action="{{ route('admin.orders.productsList') }}" type="text" placeholder="عنوان یا بارکد محصول" class="form-control">
                                </div>

                                <div class="col-12">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>توضیحات سفارش</label>
                                                <textarea name="description" rows="2" class="form-control">{{ $order->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center flex-column">
                                            <div class="form-group">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input id="caculate_tax" type="checkbox" name="caculate_tax" {{ $order->tax ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">محاسبه {{ option('in_person_factor_tax') }} درصد مالیات</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <strong class="mb-2 order-detail" style="display: none">جمع کل: <span id="factor_total" class="text-success"></span> تومان</strong>
                                            <strong class="order-detail" style="display: none">تعداد ردیف: <span id="factor_count" class="text-warning"></span></strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-left">
                                        <button type="submit" class="btn btn-primary ml-1 mt-1 mb-1 waves-effect waves-light">ثبت سفارش</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="add-product-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">اضافه کردن محصول</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    محصول انتخابی از قبل در سفارش وجود دارد
                </div>
                <div class="modal-footer">
                    <button id="add-new-row" type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">اضافه کردن در سطر جدید</button>
                    <button id="add-to-prev" type="button" class="btn btn-warning waves-effect waves-light" data-dismiss="modal">اضافه کردن تعداد به قبلی</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">انصراف</button>
                </div>
            </div>
        </div>
    </div>

    @include('back.orders.templates.product')
@endsection

@include('back.partials.plugins', ['plugins' => ['jquery-ui', 'persian-datepicker', 'jquery.validate']])

@push('scripts')
    <script>
        let tax_amount = {{ intval($order->tax) }};
        let productsCount = {{ $order->items()->count() }};
    </script>
    <script src="{{ asset('back/app-assets/plugins/ejs/ejs.min.js') }}"></script>
    <script src="{{ asset('back/assets/js/pages/orders/in-person-create.js') }}?v=11"></script>

    <script>
        calculate_total_price();
    </script>
@endpush
