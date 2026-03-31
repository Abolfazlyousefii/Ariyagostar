@extends('front::auth.layouts.master', ['title' =>  trans('front::messages.auth.forget-password')])

@section('content')

    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container main-container">

            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-7 col-12 mx-auto">
                    <div class="form-ui dt-sl dt-sn pt-4">
                        <div class="section-title title-wide mb-1 no-after-title-wide">
                            <h2 class="font-weight-bold">{{ trans('front::messages.auth.forget-password') }}</h2>
                        </div>
                        <form id="forgot-password-form" data-redirect="{{ route('one-time-login') }}" action="{{ route('password.send') }}" method="POST">
                            @csrf
                            <div class="form-row-title">
                                <h3>{{ trans('front::messages.auth.phone-number') }}</h3>
                            </div>
                            <div class="form-row with-icon form-group">
                                <input id="mobile" type="text" name="mobile" class="input-ui pr-2" placeholder="{{ trans('front::messages.auth.enter-mobile-number') }}" value="">
                                <i class="mdi mdi-account-circle-outline"></i>
                            </div>

                            <div class="form-row mt-4">
                                <div class="col-md-8 col-6">
                                    <div class="form-group">
                                        <input type="text" class="input-ui pl-2 captcha" autocomplete="off" name="captcha" placeholder="{{ trans('front::messages.auth.security-code') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <img class="captcha w-100" src="{{ captcha_src('flat') }}" alt="captcha">
                                </div>
                            </div>

                            <div class="form-row mt-3">
                                <button type="submit" class="btn-primary-cm btn-with-icon mx-auto w-100">
                                    <i class="mdi mdi-lock-open-variant-outline"></i>
                                    {{ trans('front::messages.auth.request-verification-code') }}
                                </button>
                            </div>

                            <div class="form-footer text-right mt-3">
                                <span class="d-block font-weight-bold">{{ trans('front::messages.auth.are-you-a-new-user') }}</span>
                                <a href="{{ route('register') }}" class="d-inline-block mr-3 mt-2">{{ trans('front::messages.auth.register-on-the-site') }}</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <!-- End main-content -->

@endsection

@push('scripts')
    <script src="{{ theme_asset('js/pages/forgot-password.js') }}?v=2"></script>
@endpush
