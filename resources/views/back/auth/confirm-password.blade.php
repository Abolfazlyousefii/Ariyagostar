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
                                <img src="{{ asset('back/app-assets/images/pages/lock-screen.png') }}" alt="branding logo">
                            </div>
                            <div id="main-card" class="col-lg-6 col-12 p-0">
                                <div class="card rounded-0 mb-0 px-2" style="height: 100%">
                                    <div class="card-header pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">گذرواژه تان را وارد کنید</h4>
                                        </div>
                                    </div>
                                    <div class="card-content mb-2">
                                        <div class="card-body pt-1">
                                            <form id="login-form" method="POST" action="{{ route('password.confirm') }}">
                                                @csrf

                                                <fieldset class="form-label-group position-relative has-icon-left">
                                                    <input type="password" class="form-control" id="user-password" name="password" required autocomplete="current-password" placeholder="گذرواژه">
                                                    <div class="form-control-position">
                                                        <i class="feather icon-lock"></i>
                                                    </div>
                                                    <label for="user-password">گذرواژه</label>
                                                </fieldset>
                                                <button type="submit" class="btn btn-primary float-right btn-inline">ورود به سیستم</button>
                                            </form>
                                        </div>
                                        <a href="{{ route('logout') }}">خروج</a>
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
