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
                                    <li class="breadcrumb-item">مدیریت تخفیف ها
                                    </li>
                                    <li class="breadcrumb-item active">ایجاد تخفیف
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <!-- Description -->
                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">ایجاد تخفیف جدید</h4>
                    </div>

                    <div id="main-card" class="card-content overflow-hidden">
                        <div class="card-body">
                            <div class="col-12 col-md-12">
                                <form class="form" id="discount-create-form" action="{{ route('admin.discounts.store') }}" data-redirect="{{ route('admin.discounts.index') }}" method="post">
                                    @csrf

                                    <div class="nav-vertical">
                                        <ul class="nav nav-tabs nav-left flex-column" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="baseVerticalLeft-tab1" data-toggle="tab" aria-controls="tabVerticalLeft1" href="#tabVerticalLeft1" role="tab" aria-selected="true">اطلاعات</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="baseVerticalLeft-tab2" data-toggle="tab" aria-controls="tabVerticalLeft2" href="#tabVerticalLeft2" role="tab" aria-selected="false">محدودیت ها</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tabVerticalLeft1" role="tabpanel" aria-labelledby="baseVerticalLeft-tab1">
                                                <div class="col-12">
                                                    <div class="row">

                                                        <div class="col-md-3 col-12">
                                                            <div class="form-group">
                                                                <label>عنوان</label>
                                                                <input type="text" class="form-control carrier-method-required" name="title">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>روش اعمال تخفیف</label>
                                                                <select id="discount-method" class="form-control carrier-method-required" name="method">
                                                                    <option value="code">با کد</option>
                                                                    <option value="direct">مستقیم روی محصولات</option>
                                                                    <option value="carrier">ارسال رایگان</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 direct-hide">
                                                            <label>کد تخفیف</label>
                                                            <div class="input-group form-group">
                                                                <input type="text" class="form-control carrier-method-required" name="code">
                                                                <div id="generate-new-code" class="input-group-append">
                                                                    <span class="input-group-text">ایجاد خودکار</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>نوع تخفیف</label>
                                                                <select id="discount-type" class="form-control" name="type">
                                                                    <option value="percent">درصد</option>
                                                                    <option class="direct-hide" value="amount">مبلغ</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 direct-hide">
                                                            <label>تاریخ شروع</label>
                                                            <div class="input-group form-group">
                                                                <input autocomplete="off" type="text" class="form-control carrier-method-required" id="start_date_picker">
                                                                <input type="hidden" name="start_date" id="start_date">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="feather icon-calendar"></i></span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>تاریخ پایان</label>
                                                            <div class="input-group form-group">
                                                                <input autocomplete="off" type="text" class="form-control carrier-method-required" id="end_date_picker">
                                                                <input type="hidden" name="end_date" id="end_date">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 direct-hide" style="display: none">
                                                            <div class="form-group">
                                                                <label>مقدار تخفیف</label>
                                                                <input type="number" class="form-control" name="price">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 percent" style="display: none">
                                                            <div class="form-group">
                                                                <label>درصد تخفیف</label>
                                                                <input type="number" class="form-control" step="any" name="percent">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 percent" style="display: none">
                                                            <div class="form-group">
                                                                <label>سقف تخفیف</label>
                                                                <input type="number" class="form-control" name="discount_ceiling">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3 direct-hide">
                                                            <div class="form-group">
                                                                <label>کمترین مبلغ سفارش</label>
                                                                <input type="number" class="form-control" id="least_price" name="least_price">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 direct-hide">
                                                            <div class="form-group">
                                                                <label>کمترین تعداد محصول در سبد</label>
                                                                <input type="number" class="form-control" name="least_products_count">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group">
                                                                <label>توضیحات</label>
                                                                <textarea class="form-control" rows="2" name="description"></textarea>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row direct-hide">
                                                        <div class="col-12 col-md-3">
                                                            <fieldset class="checkbox">
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    <input class="carrier-method-required" type="checkbox" name="published" checked>
                                                                    <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span>انتشار تخفیف؟</span>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tabVerticalLeft2" role="tabpanel" aria-labelledby="baseVerticalLeft-tab2">
                                                <div class="col-12">
                                                    <div class="row">

                                                        <div class="col-md-4 direct-hide">
                                                            <div class="form-group">
                                                                <label>انتخاب مشتریان</label>
                                                                <select id="users-include" class="form-control" name="include_users" multiple>
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 direct-hide">
                                                            <div class="form-group">
                                                                <label>تعداد مجاز برای استفاده</label>
                                                                <input id="quantity" type="number" class="form-control" name="quantity">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 direct-hide">
                                                            <div class="form-group">
                                                                <label>تعداد مجاز برای هر کاربر</label>
                                                                <input type="number" class="form-control" name="quantity_per_user">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>محصولاتی که شامل تخیف میشوند</label>
                                                                <select id="discount-products-include" class="form-control" name="include_type">
                                                                    <option class="direct-hide" value="all">اعمال روی همه محصولات</option>
                                                                    <option value="category">انتخاب دسته بندی</option>
                                                                    <option value="product">انتخاب محصول</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div id="categories-include" class="form-group" style="display: none;">
                                                                <label>انتخاب دسته بندی</label>
                                                                <select id="categories-include-select" class="form-control" name="include_categories[]" multiple>
                                                                    @foreach ($categories as $category)
                                                                        <option class="l{{ $category->parents()->count() + 1 }} {{ $category->categories()->count() ? 'non-leaf' : '' }}" data-pup="{{ $category->category_id }}" value="{{ $category->id }}">{{ $category->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div id="products-include" class="form-group" style="display: none;">
                                                                <label>انتخاب محصولات</label>
                                                                <select id="products-include-select" class="form-control" name="include_products[]" multiple>
                                                                    @foreach ($products as $product)
                                                                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row direct-hide">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>محصولاتی که شامل تخیف نمی شوند</label>
                                                                <select id="discount-products-exclude" class="form-control" name="exclude_type">
                                                                    <option value="none">هیچ کدام</option>
                                                                    <option value="category">انتخاب دسته بندی</option>
                                                                    <option value="product">انتخاب محصول</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div id="categories-exclude" class="form-group" style="display: none;">
                                                                <label>انتخاب دسته بندی</label>
                                                                <select id="categories-exclude-select" class="form-control" name="exclude_categories" multiple>
                                                                    @foreach ($categories as $category)
                                                                        <option class="l{{ $category->parents()->count() + 1 }} {{ $category->categories()->count() ? 'non-leaf' : '' }}" data-pup="{{ $category->category_id }}" value="{{ $category->id }}">{{ $category->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div id="products-exclude" class="form-group" style="display: none;">
                                                                <label>انتخاب محصولات</label>
                                                                <select id="products-exclude-select" class="form-control" name="exclude_products" multiple>
                                                                    @foreach ($products as $product)
                                                                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row direct-hide">
                                                        <div class="col-12 col-md-4">
                                                            <fieldset class="checkbox">
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    <input type="checkbox" name="only_first_purchase">
                                                                    <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span>فقط برای اولین خرید</span>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-12 col-md-4">
                                                            <fieldset class="checkbox">
                                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                                    <input type="checkbox" name="not_discount_products" checked>
                                                                    <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                    <span>مستثنی کردن محصولات تخفیف دار</span>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12 text-right">
                                        <button type="submit" class="btn btn-primary mb-1 waves-effect waves-light">ایجاد تخفیف</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Description -->

            </div>
        </div>
    </div>
@endsection

@include('back.partials.plugins', ['plugins' => ['persian-datepicker', 'jquery.validate']])

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/discounts/all.js') }}?v=3"></script>
    <script src="{{ asset('back/assets/js/pages/discounts/create.js') }}?v=2"></script>
@endpush
