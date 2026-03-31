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
                                    <li class="breadcrumb-item active">تنظیمات پیامک
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
                                    <form id="sms-form" action="{{ route('admin.settings.sms') }}" method="POST">
                                        <h4 class="my-2">تنظیمات پنل پیامک</h4>

                                        <hr>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>ارائه دهنده پنل پیامک</label>
                                                <select id="sms-panel-provider" class="form-control"
                                                        name="sms_panel_provider">
                                                    <option
                                                        value="ippanel" {{ option('sms_panel_provider', 'ippanel') == 'ippanel' ? 'selected' : '' }}>
                                                        ippanel
                                                    </option>
                                                    <option
                                                        value="kavenegar" {{ option('sms_panel_provider', 'ippanel') == 'kavenegar' ? 'selected' : '' }}>
                                                        کاوه نگار
                                                    </option>
                                                    <option
                                                        value="melipayamak" {{ option('sms_panel_provider', 'ippanel') == 'melipayamak' ? 'selected' : '' }}>
                                                        ملی پیامک
                                                    </option>
                                                    <option
                                                        value="idehpardazan" {{ option('sms_panel_provider', 'ippanel') == 'idehpardazan' ? 'selected' : '' }}>
                                                        ایده پردازان
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>شماره تلفن مدیر برای ارسال اطلاع رسانی ها</label>
                                                <div class="input-group mb-75">
                                                    <input type="text" name="admin_mobile_number"
                                                           class="form-control ltr"
                                                           value="{{ option('admin_mobile_number') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-2 mb-4">

                                            <div class="form-group col-md-4">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input data-class="sms_on_user_register" type="checkbox"
                                                               name="sms_on_user_register" {{ option('sms_on_user_register') == 'on' ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">ارسال پیامک موقع ایجاد کاربر</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input data-class="sms_to_verify_user" type="checkbox"
                                                               name="sms_to_verify_user" {{ option('sms_to_verify_user') == 'on' ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">تایید کاربر با شماره همراه</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input data-class="forgot_password_link" type="checkbox"
                                                               name="forgot_password_link" {{ option('forgot_password_link') == 'on' ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">بازیابی رمز عبور با کد تایید</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input data-class="login_with_code" type="checkbox"
                                                               name="login_with_code" {{ option('login_with_code') == 'on' ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">ورود با رمز یکبار مصرف</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input data-class="sms_on_order_paid" type="checkbox"
                                                               name="sms_on_order_paid" {{ option('sms_on_order_paid') == 'on' ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">ارسال پیامک به مدیر موقع پرداخت سفارش</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input data-class="detail_sms_on_order_paid" type="checkbox"
                                                               name="detail_sms_on_order_paid" {{ option('detail_sms_on_order_paid') == 'on' ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">ارسال آیتم های سفارش به مدیر</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input data-class="user_sms_on_order_paid" type="checkbox"
                                                               name="user_sms_on_order_paid" {{ option('user_sms_on_order_paid') == 'on' ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">ارسال پیامک به کاربر موقع پرداخت سفارش</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input data-class="user_sms_on_in_person_order" type="checkbox"
                                                               name="user_sms_on_in_person_order" {{ option('user_sms_on_in_person_order') == 'on' ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">ارسال پیامک به کاربر برای سفارش حضوری</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input data-class="tracking_code_sms" type="checkbox"
                                                               name="tracking_code_sms" {{ option('tracking_code_sms') == 'on' ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span
                                                            class="">ارسال پیامک به کاربر موقع ثبت کد پیگیری سفارش</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input data-class="wallet_increase_sms" type="checkbox"
                                                               name="wallet_increase_sms" {{ option('wallet_increase_sms') == 'on' ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">ارسال پیامک افزایش موجودی کیف پول</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input data-class="wallet_decrease_sms" type="checkbox"
                                                               name="wallet_decrease_sms" {{ option('wallet_decrease_sms') == 'on' ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">ارسال پیامک کاهش موجودی کیف پول</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input data-class="stock-amount-increased" type="checkbox"
                                                               name="stock-amount-increased_sms" {{ option('stock-amount-increased_sms') == 'on' ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                        <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                        </span>
                                                        <span class="">ارسال پیامک اطلاع‌رسانی موجود شدن کالا</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>

                                        @include('back.settings.partials.ippanel-sms')
                                        @include('back.settings.partials.kavenegar-sms')
                                        @include('back.settings.partials.melipayamak-sms')
                                        @include('back.settings.partials.idehpardazan-sms')

                                        <div class="row">
                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                                <button type="submit" class="btn btn-primary glow">ذخیره تغییرات
                                                </button>
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

@php
    $help_videos = [config('general.video-helpes.sms-config')];
@endphp

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/settings/sms.js') }}?v=6"></script>
@endpush
