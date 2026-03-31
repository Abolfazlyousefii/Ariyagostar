@extends('back.auth.layouts.master', ['title' => 'تغییر رمز عبور'])

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-xl-7 col-10 d-flex justify-content-center">
                        <div class="card bg-authentication rounded-0 mb-0 w-100">
                            <div class="row m-0">
                                <div class="col-lg-6 d-lg-block d-none text-center align-self-center p-0">
                                    <img src="{{ asset('back/app-assets/images/pages/reset-password.png') }}" alt="branding logo">
                                </div>
                                <div class="col-lg-6 col-12 p-0">
                                    <div class="card rounded-0 mb-0 px-2">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">تغییر رمز عبور</h4>
                                            </div>
                                        </div>
                                        <p class="px-2">شما باید رمز عبورتان را تغییر دهید!</p>
                                        <div class="card-content">
                                            <div class="card-body pt-1">
                                                <form id="change-password-form" action="{{ route('change-password') }}" method="post">

                                                    <fieldset class="form-label-group">
                                                        <input type="password" class="form-control" autocomplete="off" id="password" name="password" placeholder="رمز عبور جدید" required>
                                                        <label for="password">رمز عبور جدید</label>
                                                    </fieldset>

                                                    <fieldset class="form-label-group">
                                                        <input type="password" class="form-control" autocomplete="off" id="confirm-password" name="password_confirmation" placeholder="تایید رمز عبور جدید" required>
                                                        <label for="confirm-password">تایید رمز عبور جدید</label>
                                                    </fieldset>
                                                    <div class="row pt-2">
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-block px-0">برگشت به صفحه ورود</a>
                                                        </div>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <button type="submit" class="btn btn-primary btn-block px-0">تغییر رمز عبور</button>
                                                        </div>
                                                    </div>
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

    <script src="{{ asset('back/assets/js/pages/change-password.js') }}"></script>
@endpush
