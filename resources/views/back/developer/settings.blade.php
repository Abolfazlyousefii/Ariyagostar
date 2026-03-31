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
                                    <li class="breadcrumb-item">توسعه دهنده
                                    </li>
                                    <li class="breadcrumb-item active">تنظیمات توسعه دهنده
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

                    <div id="main-card" class="card-content">
                        <div class="card-body">

                            <div class="col-12">
                                <h3>کرون جاب</h3>
                                <hr>

                                @if ($schedule_run)
                                    <div class="alert alert-success" role="alert">
                                        <i class="feather icon-check mr-1 align-middle"></i>
                                        <span>شما به درستی کرون جاب را برای فروشگاه تنظیم کرده اید.</span>
                                    </div>
                                    <div class="alert alert-success" role="alert">
                                        <p class="ltr">last work: {{ option('schedule_run') }}</p>
                                    </div>
                                @else
                                    <div class="alert alert-danger" role="alert">
                                        <i class="feather icon-x-circle mr-1 align-middle"></i>
                                        <span>کرون جاب به درستی تنظیم نشده است. <a target="_blank" href="https://laravel.com/docs/{{ config('installer.laravel-version') }}/scheduling#running-the-scheduler">راهنمای تنظیم کرون جاب</a></span>
                                    </div>

                                    @if (option('schedule_run'))
                                        <div class="alert alert-danger" role="alert">
                                            <p class="ltr">last work: {{ option('schedule_run') }}</p>
                                        </div>
                                    @endif
                                @endif

                            </div>

                            <div class="col-md-12">

                                <h3 class="mt-5"> حالت بروزرسانی</h3>
                                <hr>
                                @if (is_file(storage_path('framework/down')))
                                    <form class="developer-form" action="{{ route('admin.developer.upApplication') }}" method="POST">
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-lg btn-relief-success mb-1 waves-effect waves-light">غیر فعال کردن حالت بروزرسانی</button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <form id="downApplication-form" action="{{ route('admin.developer.downApplication') }}" method="POST">

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="alert alert-info" role="alert">
                                                    <p>پس از فعال کردن حالت بروزرسانی شما میتوانید از این آدرس وارد وبسایت شوید.</p>
                                                    <p><span>{{ url('/') }}</span><span id="downApplication-secret">/{{ $random_str }}</span></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>secret</label>
                                                <div class="input-group mb-1">
                                                    <input id="downApplication-secret-input" type="text" name="secret" class="form-control ltr" value="{{ $random_str }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                    <label>عنوان</label>
                                                    <input type="text" class="form-control" name="info_maintenance_mode_title" value="{{ option('info_maintenance_mode_title', 'در حال بروزرسانی هستیم!') }}" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>توضیحات</label>
                                                    <textarea class="form-control" rows="4" name="info_maintenance_mode_description">{{ option('info_maintenance_mode_description', 'در حال بروزرسانی وبسایت هستیم لطفا دقایقی بعد مراجعه کنید.<br>از صبر و شکیبایی شما متشکریم.') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <button type="submit" class="btn btn-lg btn-relief-danger mb-1 waves-effect waves-light">فعال کردن حالت بروزرسانی</button>
                                            </div>
                                        </div>
                                    </form>

                                @endif

                                <h3 class="mt-5"> اعلانات وب پوش</h3>
                                <hr>

                                <form class="developer-form" action="{{ route('admin.developer.webpushNotification') }}" method="POST">
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-lg btn-relief-success mb-1 waves-effect waves-light">تنظیم کلیدهای وب پوش</button>
                                        </div>

                                        <div class="col-12">
                                            <div class="alert alert-info" role="alert">
                                                <p>کلیدهای فعلی:</p>
                                                <p class="text-right"><strong>VAPID_PUBLIC_KEY:</strong> {{ config('webpush.vapid.public_key') }}</p>
                                                <p class="text-right"><strong>VAPID_PRIVATE_KEY:</strong> {{ config('webpush.vapid.private_key') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <form class="developer-form" action="{{ route('admin.developer.settings') }}" method="POST">
                                    @method('put')
                                    <h3 class="mt-5">تنظیمات دیگر</h3>
                                    <hr>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>شماره سفارش</label>
                                            <div class="input-group mb-75">
                                                <input type="text" name="SELF_UPDATER_HTTP_PRIVATE_ACCESS_TOKEN" class="form-control ltr" value="{{ config('self-update.updater_token') }}">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-md-3">
                                            <fieldset class="checkbox">
                                                <abbr title="در حالت توسعه فایل های js و css کامپایل نشده اند">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="app_debug_mode" {{ config('app.debug') == true ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class="">فعال کردن حالت توسعه</span>
                                                    </div>
                                                </abbr>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-3">
                                            <fieldset class="checkbox">
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="debugbar_enabled" {{ config('debugbar.enabled') == true ? 'checked' : '' }}>
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">فعال کردن دیباگ بار</span>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-3">
                                            <fieldset class="checkbox">
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="enable_help_videos" {{ option('enable_help_videos', 'true') == 'true' ? 'checked' : '' }}>
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">فعال کردن آموزش تصویری صفحات</span>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-3">
                                            <fieldset class="checkbox">
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="enable_old_updates" {{ option('enable_old_updates', 'true') == 'true' ? 'checked' : '' }}>
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <small class="">فعال کردن متد قدیمی آپدیت (این متد اکسپایر شده)</small>
                                                </div>
                                            </fieldset>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                            <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">ذخیره تغییرات</button>

                                        </div>
                                    </div>
                                </form>
                                <!-- users edit socail form ends -->
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Description -->

            </div>
        </div>
    </div>

@endsection

@include('back.partials.plugins', ['plugins' => ['jquery-validation']])

@php
    $help_videos = [
        config('general.video-helpes.cronjob')
    ];
@endphp

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/developer/settings.js') }}?v=2"></script>
@endpush
