@extends('back.auth.layouts.master', ['title' => 'ثبت نام'])

@section('content')

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-xl-10 col-10 d-flex justify-content-center">
                        <div class="card bg-authentication rounded-0 mb-0">
                            <div class="row m-0">
                                <div class="col-lg-5 d-lg-block d-none text-center align-self-center pl-0 pr-3 py-0">
                                    <img src="{{ asset('back/app-assets/images/pages/register.jpg') }}" alt="branding logo">
                                </div>
                                <div id="main-card" class="col-lg-7 col-12 p-0">
                                    <div class="card rounded-0 mb-0 p-2">
                                        <div class="card-header pt-50 pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">خوش آمدید</h4>
                                            </div>
                                        </div>
                                        <p class="px-2">لطفا اطلاعات زیر را تکمیل کنید.</p>
                                        <p class="px-2">توجه داشته باشید که با این اطلاعات قادر خواهید بود به پنل مدیریت دسترسی داشته باشید.</p>
                                        <div class="card-content">
                                            <div class="card-body pt-0">
                                                <form id="register-form" method="POST" action="{{ route('admin.register') }}">
                                                    @csrf

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="first_name">نام</label>
                                                                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="نام" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="last_name">نام خانوادگی</label>
                                                                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="نام خانوادگی" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="username">نام کاربری</label>
                                                                <input type="text" id="username" name="username" class="form-control" placeholder="نام کاربری" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="admin_route_prefix">پیشوند آدرس ورود به بخش مدیریت سایت</label>
                                                                <input type="text" id="admin_route_prefix" name="admin_route_prefix" class="form-control" placeholder="پیشوند آدرس ورود به بخش مدیریت سایت" value="{{ 'admin' . rand(11111,99999) }}" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="password">گذرواژه</label>
                                                                <input type="password" id="password" name="password" class="form-control" autocomplete="new-password" placeholder="گذرواژه" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="password_confirmation">تایید گذرواژه</label>
                                                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="تایید گذرواژه" required>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <button type="submit" class="btn btn-primary float-right btn-inline mb-50">ثبت نام و ورود به پنل مدیریت</a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->

@endsection

@push('scripts')
    <script src="{{ asset('back/app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('back/app-assets/plugins/jquery-validation/localization/messages_fa.min.js') }}"></script>
    <script src="{{ asset('back/assets/js/pages/register.js') }}"></script>
@endpush
