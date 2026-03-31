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
                                    <li class="breadcrumb-item">سفارشات</li>
                                    <li class="breadcrumb-item active">ایجاد سفارش</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <h4 class="card-title">ایجاد سفارش جدید</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" data-auto-complete-url="{{ route('admin.orders.userInfo') }}" id="order-create-form" action="{{ route('admin.orders.store') }}" data-redirect="{{ route('admin.orders.index') }}" method="post">
                                @csrf

                                <div class="nav-vertical">
                                    <ul class="nav nav-tabs nav-left flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="user-info-tab" data-toggle="tab" aria-controls="user-info-tab-content" href="#user-info-tab-content" role="tab" aria-selected="true">اطلاعات کاربر</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="address-tab" data-toggle="tab" aria-controls="address-tab-content" href="#address-tab-content" role="tab" aria-selected="false">آدرس</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="products-tab" data-toggle="tab" aria-controls="products-tab-content" href="#products-tab-content" role="tab" aria-selected="false">انتخاب محصولات</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="order-info-tab" data-toggle="tab" aria-controls="order-info-tab-content" href="#order-info-tab-content" role="tab" aria-selected="false">اطلاعات سفارش</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="user-info-tab-content" role="tabpanel" aria-labelledby="user-info-tab">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>شماره همراه (نام کاربری)</label>
                                                            <input type="text" class="form-control" name="username">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>نام</label>
                                                            <input type="text" class="form-control" name="first_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>نام خانوادگی</label>
                                                            <input type="text" class="form-control" name="last_name">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="address-tab-content" role="tabpanel" aria-labelledby="address-tab">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>استان</label>
                                                            <select id="province" data-action="{{ route('provinces.get-cities') }}" name="province_id" class="form-control">
                                                                @foreach ($provinces as $province)
                                                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div id="city-div" class="form-group">
                                                            <label>شهر</label>
                                                            <select id="city" name="city_id" class="form-control">
                                                                <option value="">انتخاب کنید</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>کد پستی</label>
                                                            <input type="text" class="form-control" name="postal_code">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>آدرس کامل</label>
                                                            <textarea name="address" rows="2" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="products-tab-content" role="tabpanel" aria-labelledby="products-tab">
                                            <div class="col-12" id="order-products-list"></div>

                                            <div class="col-md-8 offset-md-2 text-center mt-2">
                                                <input id="add-product-to-order" data-action="{{ route('admin.orders.productsList') }}" type="text" placeholder="افزودن محصول" class="form-control">
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="order-info-tab-content" role="tabpanel" aria-labelledby="order-info-tab">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>تخفیف (تومان)</label>
                                                            <input type="number" class="form-control amount-input" name="discount_amount">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>نحوه ارسال</label>
                                                            <select name="carrier_id" class="form-control">
                                                                <option value="">بدون ارسال</option>
                                                                @foreach ($carriers as $carrier)
                                                                    <option value="{{ $carrier->id }}">{{ $carrier->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>هزینه ارسال (تومان)</label>
                                                            <input type="number" class="form-control amount-input" name="shipping_cost">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>وضعیت ارسال</label>
                                                            <select name="shipping_status" class="form-control">
                                                                <option value="pending">در حال بررسی</option>
                                                                <option value="wating">منتظر ارسال</option>
                                                                <option value="sent">ارسال شد</option>
                                                                <option value="canceled">ارسال لغو شد</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>توضیحات سفارش</label>
                                                            <textarea name="description" rows="2" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">ثبت سفارش</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('back.orders.templates.product')

@endsection

@include('back.partials.plugins', ['plugins' => ['jquery-ui', 'persian-datepicker', 'jquery.validate']])

@push('scripts')
    <script src="{{ asset('back/app-assets/plugins/ejs/ejs.min.js') }}"></script>
    <script src="{{ asset('back/assets/js/pages/orders/create.js') }}?v=1"></script>
@endpush
