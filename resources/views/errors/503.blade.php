@extends('errors.layouts.master', ['title' => 'در حال بروزرسانی'])

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- maintenance -->
                <section class="row flexbox-container">
                    <div class="col-xl-7 col-md-8 col-12 d-flex justify-content-center">
                        <div class="card auth-card bg-transparent shadow-none rounded-0 mb-0 w-100">
                            <div class="card-content">
                                <div class="card-body text-center">
                                    <img src="{{ asset('back/app-assets/images/pages/maintenance-2.png') }}" class="img-fluid align-self-center" alt="در حال بروزرسانی">
                                    <h1 class="font-large-2 my-3">{{ option('info_maintenance_mode_title') }}</h1>
                                    <div class="px-2">{!! option('info_maintenance_mode_description') !!}</div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- maintenance end -->

            </div>
        </div>
    </div>
@endsection
