@extends('errors.layouts.master', ['title' => 'خطای سرور'])

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- error 500 -->
                <section class="row flexbox-container">
                    <div class="col-xl-7 col-md-8 col-12 d-flex justify-content-center">
                        <div class="card auth-card bg-transparent shadow-none rounded-0 mb-0 w-100">
                            <div class="card-content">
                                <div class="card-body text-center">
                                    <img src="{{ asset('back/app-assets/images/pages/500.png') }}" class="img-fluid align-self-center" alt="branding logo">
                                    <h1 class="font-large-2 mt-1 mb-0">خطای سرور!</h1>
                                    <p class="p-3">
                                        متاسفانه خطایی در سرور رخ داده است لطفا از بخش تماس با ما این خطا را گزارش دهید
                                    </p>
                                    <a class="btn btn-primary btn-lg" href="{{ url('/') }}">بازگشت به صفحه اصلی</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- error 500 end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
