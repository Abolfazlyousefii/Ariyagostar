@extends('back.auth.layouts.master', ['title' => 'ورود'])

@section('content')

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="row flexbox-container">
                <div class="col-xl-8 col-11 d-flex justify-content-center">

                    <div class="card bg-authentication rounded-0 mb-0">

                        <div class="row m-0">

                            <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                                <img src="{{ asset('back/app-assets/images/pages/login.png') }}" alt="branding logo">
                            </div>
                            <div id="main-card" class="col-lg-6 col-12 p-0">
                                <div class="card rounded-0 mb-0 px-2">
                                    <div class="card-header pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">ورود به سیستم</h4>
                                        </div>
                                    </div>
                                    <p class="px-2">لطفا فیلدهای زیر را پر کنید.</p>
                                    <div class="card-content mb-2">
                                        <div class="card-body pt-1">
                                            <form id="login-form" method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control" id="user-name" placeholder="نام کاربری" name="username" value="{{ old('username') }}">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-user"></i>
                                                    </div>
                                                    <label for="user-name">نام کاربری</label>
                                                </fieldset>

                                                <fieldset class="form-label-group position-relative has-icon-left">
                                                    <input type="password" class="form-control" id="user-password" name="password" placeholder="گذرواژه">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-lock"></i>
                                                    </div>
                                                    <label for="user-password">گذرواژه</label>
                                                </fieldset>
                                                <div class="form-group d-flex justify-content-between align-items-center">
                                                    <div class="text-left">
                                                        <fieldset class="checkbox">
                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                <input type="checkbox" name="remember" {{ old('username') ? 'checked' : '' }}>
                                                                <span class="vs-checkbox">
                                                                    <span class="vs-checkbox--check">
                                                                        <i class="vs-icon feather icon-check"></i>
                                                                    </span>
                                                                </span>
                                                                <span>مرا بخاطر بسپار</span>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary float-right btn-inline">ورود به سیستم</button>
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

@endsection

@push('scripts')
    <script>
        var redirect_url = '{{ Redirect::intended()->getTargetUrl() }}';
    </script>
    <script src="{{ asset('back/assets/js/pages/login.js') }}"></script>
@endpush
