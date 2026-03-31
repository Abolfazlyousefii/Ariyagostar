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
                                    <li class="breadcrumb-item active">افزودن سفارش حضوری</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <h4 class="card-title">افزودن سفارش حضوری</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" data-auto-complete-url="{{ route('admin.orders.userInfo') }}" id="order-create-form" action="{{ route('admin.orders.inPersonStore') }}" method="post">
                                @csrf

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>شماره موبایل <small>(نام کاربری)</small></label>
                                                <input type="text" class="form-control" name="username">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>نام</label>
                                                <input type="text" class="form-control" name="first_name" value="مشتری">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>نام خانوادگی</label>
                                                <input type="text" class="form-control" name="last_name" value="گرامی">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12" id="order-products-list"></div>

                                <div class="col-md-6 text-center mt-3 mb-4">
                                    <input id="add-product-to-order" data-action="{{ route('admin.orders.productsList') }}" type="text" placeholder="عنوان یا بارکد محصول" class="form-control">
                                </div>

                                <div class="col-12">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>توضیحات سفارش</label>
                                                <textarea name="description" rows="2" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center flex-column">
                                            <div class="form-group">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input id="caculate_tax" type="checkbox" name="caculate_tax" {{ option('in_person_tax', 0) == 1 ? 'checked' : '' }}>
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
                    <button id="add-new-row" type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">اضافه کردن  در سطر جدید</button>
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
        let tax_amount = {{ intval(option('in_person_factor_tax')) }};
        let productsCount = 0;
    </script>
    <script src="{{ asset('back/app-assets/plugins/ejs/ejs.min.js') }}"></script>
    <script src="{{ asset('back/assets/js/pages/orders/in-person-create.js') }}?v=11"></script>
@endpush
