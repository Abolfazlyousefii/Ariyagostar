@extends('front::layouts.master', ['title' => trans('front::messages.errors.page-error-not-found') ])

@section('content')
    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container main-container">

            <div class="row">
                <div class="col-12">
                    <div class="dt-sl dt-sn pt-3 pb-5">
                        <div class="error-page text-center">
                            <h1>{{ trans('front::messages.errors.page-not-found') }}</h1>
                            <a href="/" class="btn-primary-cm">{{ trans('front::messages.errors.go-to-main-page') }}</a>
                            <img src="{{ theme_asset("img/theme/404.svg") }}" class="img-fluid" width="60%" alt="">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <!-- End main-content -->
@endsection
