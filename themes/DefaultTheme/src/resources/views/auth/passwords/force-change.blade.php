@extends('front::auth.layouts.master', ['title' =>  trans('front::messages.auth.change-password') ])

@section('content')

    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
            <div class="container main-container">

                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 col-12 mx-auto">
                        <div class="form-ui dt-sl dt-sn pt-4">
                            <div class="section-title title-wide mb-1 no-after-title-wide">
                                <h2 class="font-weight-bold">{{ trans('front::messages.auth.change-password') }}</h2>
                            </div>
                            <div class="message-light">
                                {{ trans('front::messages.auth.change-your-password') }}
                            </div>
                            <form id="force-password-change-form" action="{{ route('front.user.force-update-password') }}" method="POST">
                                @csrf

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
                                    <input type="password" name="password_confirmation" class="input-ui pr-2" placeholder="{{ trans('front::messages.auth.enter-new-password') }}">
                                    <i class="mdi mdi-lock-reset"></i>
                                </div>

                                <div class="form-row mt-3">
                                    <button type="submit" class="btn-primary-cm btn-with-icon mx-auto w-100">
                                        <i class="mdi mdi-lock-reset"></i>
                                        {{ trans('front::messages.auth.chang-password') }}
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

@php
    $redirect_url = Redirect::intended()->getTargetUrl();
@endphp

@push('scripts')
    <script>
        var redirect_url = '{{ $redirect_url }}';
    </script>

    <script src="{{ theme_asset('js/pages/force-password-change.js') }}"></script>
@endpush
