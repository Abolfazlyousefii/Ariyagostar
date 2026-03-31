@extends('back.layouts.master')

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb no-border">
                                    <li class="breadcrumb-item">مدیریت
                                    </li>
                                    <li class="breadcrumb-item active">داشبورد
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">

                <section id="statistics-card">
                    <div class="row match-height">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header d-flex flex-column align-items-center pb-0">
                                    <div class="avatar bg-rgba-primary p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-eye text-primary font-medium-5"></i>
                                        </div>
                                    </div>
                                    <p class="mb-0 mt-1">بازدیدهای این هفته</p>
                                </div>
                                <div class="card-content">
                                    <div id="line-area-chart-1"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header d-flex flex-column align-items-center pb-0">
                                    <div class="avatar bg-rgba-danger p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-user text-danger font-medium-5"></i>
                                        </div>
                                    </div>
                                    <p class="mb-0 mt-1">بازدیدکنندگان این هفته</p>
                                </div>
                                <div class="card-content">
                                    <div id="line-area-chart-3"></div>
                                </div>
                            </div>
                        </div>

                        @if (option('enable_help_videos', 'true') == 'true')
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <h4 class="card-title mt-3">فیلم های آموزشی</h4>
                                            <p class="card-text">آموزش تصویری بخش های پنل مدیریت</p>
                                            <button type="button" data-toggle="modal" data-target="#video-helpe-modal" class="btn btn-info">مشاهده</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="avatar bg-rgba-info p-50 m-0 mb-1">
                                            <div class="avatar-content">
                                                <i class="feather icon-users text-info font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700">{{ $users_count }}</h2>
                                        <p class="mb-0 line-ellipsis">تعداد کاربران</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card text-center">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="avatar bg-rgba-warning p-50 m-0 mb-1">
                                            <div class="avatar-content">
                                                <i class="feather icon-shopping-cart text-warning font-medium-5"></i>
                                            </div>
                                        </div>
                                        <h2 class="text-bold-700">{{ $products_count }}</h2>
                                        <p class="mb-0 line-ellipsis">تعداد محصولات</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @can('orders.index')
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="avatar bg-rgba-primary p-50 m-0 mb-1">
                                                <div class="avatar-content">
                                                    <i class="feather icon-briefcase text-primary font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="text-bold-700">{{ $orders_count }}</h2>
                                            <p class="mb-0 line-ellipsis">تعداد سفارشات</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card text-center">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="avatar bg-rgba-success p-50 m-0 mb-1">
                                                <div class="avatar-content">
                                                    <i class="feather icon-credit-card text-success font-medium-5"></i>
                                                </div>
                                            </div>
                                            <h2 class="text-bold-700" title="{{ number_format($total_sell) }} تومان">{{ formatPriceUnits($total_sell) }}</h2>
                                            <p class="mb-0 line-ellipsis">جمع فروش</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan

                    </div>

                </section>

            </div>
        </div>
    </div>

@endsection

@php
    $help_videos = config('general.video-helpes');
@endphp

@push('scripts')
    <script src="{{ asset('back/app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>

    <script>
        @php
            $data   = viewers_data(7);
            $labels = array_keys($data);
            $views  = array_values($data);
        @endphp

        var viewerChartLabels = [{!! array_to_string($labels) !!}];
        var ViewerChartData   = [{!! array_to_string($views) !!}];

        @php
            $data   = ip_data(7);
            $labels = array_keys($data);
            $views  = array_values($data);
        @endphp

        var ipChartLabels = [{!! array_to_string($labels) !!}];
        var ipChartData   = [{!! array_to_string($views) !!}];
    </script>
    <script src="{{ asset('back/assets/js/pages/dashboard-ecommerce.js') }}"></script>
@endpush
