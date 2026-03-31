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
                                    <li class="breadcrumb-item">تنظیمات
                                    </li>
                                    <li class="breadcrumb-item active">تنظیمات دیگر
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- users edit start -->
                <section class="users-edit">
                    <div class="card">
                        <div id="main-card" class="card-content">
                            <div class="card-body">
                                <div class="tab-content">
                                    <form id="others-form" action="{{ route('admin.settings.others') }}" method="POST">
                                        <h4 class="mt-2">تنظیمات قیمت ها</h4>
                                        <div class="row">
                                            <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                    <label>انتخاب ارز پیش فرض</label>
                                                    <select name="default_currency_id" class="form-control">
                                                        <option value="">تومان (پیش فرض)</option>
                                                        @foreach ($currencies as $currency)
                                                            <option value="{{ $currency->id }}" {{ option('default_currency_id') == $currency->id ? 'selected' : '' }}>{{ $currency->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                    <label>گرد کردن</label>
                                                    <select name="default_rounding_amount" class="form-control">
                                                        <option value="no" {{ option('default_rounding_amount', 'no') == 'no' ? 'selected' : '' }}>خیر</option>
                                                        <option value="100" {{ option('default_rounding_amount') == 100 ? 'selected' : '' }}>100 تومان</option>
                                                        <option value="1000" {{ option('default_rounding_amount') == 1000 ? 'selected' : '' }}>1000 تومان</option>
                                                        <option value="10000" {{ option('default_rounding_amount') == 10000 ? 'selected' : '' }}>10000 تومان</option>
                                                        <option value="100000" {{ option('default_rounding_amount') == 100000 ? 'selected' : '' }}>100000 تومان</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>نحوه گرد کردن</label>
                                                    <select name="default_rounding_type" class="form-control">
                                                        <option value="close" {{ option('default_rounding_type', 'close') == 'close' ? 'selected' : '' }}>نزدیک</option>
                                                        <option value="up" {{ option('default_rounding_type') == 'up' ? 'selected' : '' }}>رو به بالا</option>
                                                        <option value="down" {{ option('default_rounding_type') == 'down' ? 'selected' : '' }}>رو به پایین</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <h4 class="mt-2">تنظیمات فاکتور سفارشات</h4>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <fieldset class="form-group">
                                                    <label for="">لوگو</label>
                                                    <div class="custom-file">
                                                        <input type="file" accept="image/*" name="factor_logo" class="custom-file-input">
                                                        <label class="custom-file-label" for="">{{ option('factor_logo') }}</label>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-3">
                                                <label>عنوان فاکتور</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="factor_title" class="form-control" value="{{ option('factor_title', option('info_site_title')) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>فروشنده</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="factor_seller_name" class="form-control" value="{{ option('factor_seller_name') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>شناسه ملی</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="factor_national_code" class="form-control" value="{{ option('factor_national_code') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>شناسه ثبت</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="factor_registeration_id" class="form-control" value="{{ option('factor_registeration_id') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>شماره اقتصادی</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="factor_economical_number" class="form-control" value="{{ option('factor_economical_number') }}">
                                                </div>
                                            </div>

                                        </div>

                                        <h4 class="mt-2">تنظیمات فاکتور سفارش حضوری</h4>
                                        <div class="row">

                                            <div class="col-md-3">
                                                <label>عنوان فاکتور</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="in_person_factor_title" class="form-control" value="{{ option('in_person_factor_title') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label>درصد مالیات</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="in_person_factor_tax" class="form-control" value="{{ option('in_person_factor_tax') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label>محاسبه مالیات بصورت پیشفرض</label>
                                                <div class="input-group mb-75">
                                                    <select name="in_person_tax" class="form-control">
                                                        <option value="0" {{ option('in_person_tax', 0) == 0 ? 'selected' : '' }}>خیر</option>
                                                        <option value="1" {{ option('in_person_tax', 0) == 1 ? 'selected' : '' }}>بله</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <label>متن فوتر</label>
                                                <div class="input-group mb-75">
                                                    <textarea name="in_person_factor_footer" class="form-control" rows="3">{{ option('in_person_factor_footer') }}</textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <h4 class="mt-2">تنظیمات مربوط به کاربران</h4>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>اعتبار هدیه ثبت نام کاربر</label>
                                                <div class="input-group mb-75">
                                                    <input type="number" name="user_register_gift_credit" class="form-control" min="0" value="{{ option('user_register_gift_credit', 0) }}">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label>فعال کردن امکان معرفی افراد</label>
                                                <div class="input-group mb-75">
                                                    <select name="user_refrral_enable" class="form-control">
                                                        <option value="0" {{ option('user_refrral_enable', 0) == 0 ? 'selected' : '' }}>خیر</option>
                                                        <option value="1" {{ option('user_refrral_enable', 1) == 1 ? 'selected' : '' }}>بله</option>
                                                    </select>
                                                </div>


                                            </div>

                                            <div class="col-md-3">
                                                <label> مقدار تخفیف معرفی کننده به درصد</label>
                                                <div class="input-group mb-75">
                                                    <input type="number" name="owner_refrral_amount" class="form-control" min="0" value="{{ option('owner_refrral_amount', 0) }}">
                                                </div>

                                            </div>
                                            <div class="col-md-3">

                                                <label> مقدار تخفیف معرفی شونده به درصد</label>
                                                <div class="input-group mb-75">
                                                    <input type="number" name="user_refrral_amount" class="form-control" min="0" value="{{ option('user_refrral_amount', 0) }}">
                                                </div>

                                            </div>
                                        </div>

                                        <h4 class="mt-2">تنظیمات pusher</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>PUSHER_APP_ID</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="PUSHER_APP_ID" class="form-control ltr" value="{{ config('broadcasting.connections.pusher.app_id') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>PUSHER_APP_KEY</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="PUSHER_APP_KEY" class="form-control ltr" value="{{ config('broadcasting.connections.pusher.key') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>PUSHER_APP_SECRET</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="PUSHER_APP_SECRET" class="form-control ltr" value="{{ config('broadcasting.connections.pusher.secret') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>PUSHER_APP_CLUSTER</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="PUSHER_APP_CLUSTER" class="form-control ltr" value="{{ config('broadcasting.connections.pusher.options.cluster') }}">
                                                </div>
                                            </div>

                                        </div>

                                        <h4 class="mt-2">مخفی کردن سایت از موتور های جستجو</h4>
                                        <span class="text-danger small">
                                            <i class="feather icon-alert-octagon"></i>
                                            غیرفعال کردن این گزینه موجب عدم نمایش سایت در موتور های جست و جو میشود.
                                        </span>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label> در صفحه اصلی سایت</label>

                                                <select name="allow_indexing_main_page" class="form-control">
                                                    <option value="on"  {{ option('allow_indexing_main_page') == "on" ? 'selected' : '' }}>فعال</option>
                                                    <option value="off" {{ option('allow_indexing_main_page') == "off" ? 'selected' : '' }} >غیر فعال</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label> در لیست محصولات سایت</label>
                                                <select name="allow_indexing_product_page" class="form-control">
                                                    <option value="on"  {{ option('allow_indexing_product_page') == "on" ? 'selected' : '' }}>فعال</option>
                                                    <option value="off" {{ option('allow_indexing_product_page') == "off" ? 'selected' : '' }}>غیر فعال</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label> در لیست بلاگ های سایت</label>
                                                <select name="allow_indexing_blog_page" class="form-control">
                                                    <option value="on"  {{ option('allow_indexing_blog_page') == "on" ? 'selected' : '' }}>فعال</option>
                                                    <option value="off" {{ option('allow_indexing_blog_page') == "off" ? 'selected' : '' }}>غیر فعال</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label> در صفحات دسته بندی ها و زیر دسته ها</label>
                                                <select name="allow_indexing_categories" class="form-control">
                                                    <option value="on"  {{ option('allow_indexing_categories') == "on" ? 'selected' : '' }}>فعال</option>
                                                    <option value="off" {{ option('allow_indexing_categories') == "off" ? 'selected' : '' }}>غیر فعال</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label> در صفحه برند ها</label>
                                                <select name="allow_indexing_brands" class="form-control">
                                                    <option value="on"  {{ option('allow_indexing_brands') == "on" ? 'selected' : '' }}>فعال</option>
                                                    <option value="off" {{ option('allow_indexing_brands') == "off" ? 'selected' : '' }}>غیر فعال</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label> در صفحه درباره ما</label>
                                                <select name="allow_indexing_contact" class="form-control">
                                                    <option value="on"  {{ option('allow_indexing_contact') == "on" ? 'selected' : '' }}>فعال</option>
                                                    <option value="off" {{ option('allow_indexing_contact') == "off" ? 'selected' : '' }}>غیر فعال</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                                <button type="submit" class="btn btn-primary glow">ذخیره تغییرات</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users edit ends -->

            </div>
        </div>
    </div>

@endsection

@include('back.partials.plugins', ['plugins' => ['jquery.validate']])

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/settings/others.js') }}"></script>
@endpush
