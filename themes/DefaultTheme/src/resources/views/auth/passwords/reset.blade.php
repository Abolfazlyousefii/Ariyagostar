@extends('front::auth.layouts.master', ['title' => trans('front::messages.auth.chang-password') ])

@section('content')

    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
            <div class="container main-container">

                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 col-12 mx-auto">
                        <div class="form-ui dt-sl dt-sn pt-4">
                            <div class="section-title title-wide mb-1 no-after-title-wide">
                                <h2 class="font-weight-bold">{{ trans('front::messages.auth.chang-password') }}</h2>
                            </div>
                            <form id="reset-form" action="{{ route('front.user.password.update') }}" method="POST">
                                @csrf
                                @method('put')

                                <div class="form-row-title">
                                    <h3>{{ trans('front::messages.auth.previous-password') }}</h3>
                                </div>
                                <div class="form-row with-icon form-group">
                                    <input type="password" name="prev_password" class="input-ui pr-2" placeholder="{{ trans('front::messages.auth.enter-your-password') }}">
                                    <i class="mdi mdi-lock-open-variant-outline"></i>
                                </div>
                                <div class="form-row-title">
                                    <h3>{{ trans('front::messages.auth.new-password') }}</h3>
                                </div>
                                <div class="form-row with-icon form-group">
                                    <input id="password" type="password" name="password" class="input-ui pr-2" placeholder="{{ trans('front::messages.auth.enter-new-password') }}">
                                    <i class="mdi mdi-lock-reset"></i>
                                </div>
                                <div class="form-row-title">
                                    <h3>{{ trans('front::messages.auth.repeat-new-password') }}</h3>
                                </div>
                                <div class="form-row with-icon form-group">
                                    <input type="password" name="password_confirmation" class="input-ui pr-2" placeholder="رمز عبور جدید را وارد نمایید">
                                    <i class="mdi mdi-lock-reset"></i>
                                </div>

                                <div class="form-row mt-3">
                                    <button type="submit" class="btn-primary-cm btn-with-icon mx-auto w-100">
                                        <i class="mdi mdi-lock-reset"></i>
                                        {{ trans('front::messages.auth.change-password') }}
                                    </button>
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
        var redirect_url = '{{ route("front.user.profile") }}';
    </script>

    <script src="{{ theme_asset('js/pages/reset.js') }}"></script>
@endpush
