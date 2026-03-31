@extends('front::auth.layouts.master', ['title' => trans('front::messages.auth.register-on-the-site')])

@push('styles')
    <script src="{{ theme_asset('js/plugins/persian-jalali-date-picker/themes/bs4.js') }}"></script>
@endpush

@section('content')
    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container main-container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-8 col-12 mx-auto">
                    <div class="form-ui dt-sl dt-sn pt-4">
                        <div class="section-title title-wide mb-1 no-after-title-wide">
                            <h2 class="font-weight-bold">{{ trans('front::messages.auth.register-on-the-site') }}</h2>
                        </div>

                        <form id="register-form" class="w-100" action="{{ route('register') }}" method="POST" style="max-width: 100%">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-row-title">
                                        <h3>{{ trans('front::messages.auth.name') }}</h3>
                                    </div>
                                    <div class="form-row form-group">
                                        <input type="text" name="first_name" class="input-ui pr-2" placeholder="{{ trans('front::messages.auth.enter-your-name') }}">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-row-title">
                                        <h3>{{ trans('front::messages.auth.lname') }}</h3>
                                    </div>
                                    <div class="form-row form-group">
                                        <input type="text" name="last_name" class="input-ui pr-2" placeholder="{{ trans('front::messages.auth.enter-your-fname') }}">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-row-title">
                                        <h3>{{ trans('front::messages.auth.phone-number') }}</h3>
                                    </div>
                                    <div class="form-row with-icon form-group">
                                        <input type="text" name="username" class="input-ui pr-2" placeholder="{{ trans('front::messages.auth.enter-mobile-number') }}">
                                        <i class="mdi mdi-account-circle-outline"></i>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-row-title">
                                        <h3>تاریخ تولد <small>(اختیاری)</small></h3>
                                    </div>
                                    <div class="form-row with-icon form-group">
                                        <input data-jdp type="text" name="birthday" id="birthday" class="input-ui pr-2 ltr">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-row-title">
                                        <h3>{{ trans('front::messages.auth.password') }}</h3>
                                    </div>
                                    <div class="form-row with-icon form-group">
                                        <div class="input-group">
                                            <input id="password" type="password" name="password" class="input-ui pr-2" placeholder="{{ trans('front::messages.auth.enter-your-password') }}">
                                            <div class="input-group-append">
                                                <span class="toggle-password" style="cursor: pointer;">
                                                    <i class="mdi mdi-eye-outline" id="togglePasswordIcon"></i>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-row-title">
                                        <h3>{{ trans('front::messages.auth.repeat-the-password') }}</h3>
                                    </div>
                                    <div class="form-row with-icon form-group">
                                        <div class="input-group">
                                            <input id="password_confirmation" type="password" name="password_confirmation" class="input-ui pr-2" placeholder="{{ trans('front::messages.auth.repeat-your-password') }}">
                                            <div class="input-group-append">
                                                <span class="toggle-password" style="cursor: pointer;">
                                                    <i class="mdi mdi-eye-outline" id="togglePasswordConfirmationIcon"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if (option('user_refrral_enable', 0) == 1)
                                    <div class="col-md-6 mb-3">
                                        <div class="form-row-title">
                                            <h3>کد معرف</h3>
                                        </div>
                                        <div class="form-row form-group">
                                            <input type="text" name="referral_code" class="input-ui pr-2" placeholder="کد معرف (اختیاری)">
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-6 mb-3 d-flex align-items-end">
                                    <div class="form-row">
                                        <div class="col-md-8 col-6">
                                            <div class="form-group">
                                                <input type="text" class="input-ui pl-2 captcha" autocomplete="off" name="captcha" placeholder="{{ trans('front::messages.auth.security-code') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <img class="captcha w-100" src="{{ captcha_src('flat') }}" alt="captcha">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row mt-3">
                                <button class="btn-primary-cm btn-with-icon mx-auto w-5">
                                    <i class="mdi mdi-account-circle-outline"></i>
                                    {{ trans('front::messages.auth.register-on-the-site') }}
                                </button>
                            </div>
                            <div class="form-footer text-right mt-3">
                                <span class="d-block font-weight-bold">{{ trans('front::messages.auth.have-you-registered-before') }}</span>
                                <a href="{{ route('login') }}" class="d-inline-block mr-3 mt-2">{{ trans('front::messages.auth.enter') }}</a>
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
    <script>
        var redirect_url = '{{ request('redirect') ?: Redirect::intended()->getTargetUrl() }}';

        // Script for toggling password visibility
        document.querySelectorAll('.toggle-password').forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                const input = document.getElementById(this.closest('.input-group').querySelector('input').id);
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('mdi-eye-outline');
                    icon.classList.add('mdi-eye-off-outline');
                } else {
                    input.type = 'password';
                    icon.classList.remove('mdi-eye-off-outline');
                    icon.classList.add('mdi-eye-outline');
                }
            });
        });
    </script>
    <script src="{{ theme_asset('js/plugins/persian-jalali-date-picker/jalali-moment.browser.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/persian-jalali-date-picker/jalali-datepicker.min.js') }}"></script>
    <script src="{{ theme_asset('js/pages/register.js') }}?v=3"></script>
@endpush
