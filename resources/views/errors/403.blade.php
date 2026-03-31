@extends('errors.layouts.master', ['title' => 'اجازه دسترسی ندارید'])

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- error 404 -->
                <section class="row flexbox-container">
                    <div class="col-xl-7 col-md-8 col-12 d-flex justify-content-center">
                        <div class="card auth-card bg-transparent shadow-none rounded-0 mb-0 w-100">
                            <div class="card-content">
                                <div class="card-body text-center">
                                    <img src="{{ asset('back/app-assets/images/pages/not-authorized.png') }}" class="img-fluid align-self-center"
                                        alt="branding logo">
                                    <h1 class="font-large-2 my-1">اجازه دسترسی ندارید!</h1>
                                    <p class="p-2">
                                        شما اجازه ی دسترسی به این صفحه را ندارید.
                                    </p>
                                    <a class="btn btn-primary btn-lg mt-2" href="{{ url('/') }}">بازگشت به صفحه اصلی</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- error 404 end -->
            </div>
        </div>
    </div>
@endsection
