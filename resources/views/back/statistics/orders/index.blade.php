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
                                    <li class="breadcrumb-item">گزارشات
                                    </li>
                                    <li class="breadcrumb-item active">سفارشات
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                <section class="card" id="statistics-card">
                    <div class="card-content">
                        <div class="card-body">
                            <ul class="nav nav-tabs mb-2" id="orderstab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-toggle="tab" href="#order-values" role="tab" aria-controls="order-values" aria-selected="true">
                                      ارزش سفارشات
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-toggle="tab" href="#order-counts" role="tab" aria-controls="order-counts" aria-selected="false">
                                      تعداد سفارشات
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-toggle="tab" href="#order-users" role="tab" aria-controls="order-users" aria-selected="false">
                                      تعداد کاربران سفارش دهنده
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-toggle="tab" href="#order-products" role="tab" aria-controls="order-products" aria-selected="false">
                                      تعداد محصولات سفارشات
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="order-values" role="tabpanel" aria-labelledby="value">
                                    @include('back.statistics.orders.filter-tabs')

                                    <div id="order-values-chart" class="chart-area" style="min-height: 445px;" data-min-height="445px" data-action="{{ route('admin.statistics.orderValues') }}"></div>

                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom">کل سفارشات : <span class="orders-total"></span></span>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom">میانگین سفارشات : <span class="orders-avg"></span></span>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom"> سفارشات موفق: <span class="orders-success"></span></span>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom"> سفارشات ناموفق: <span class="orders-fail"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="order-counts" role="tabpanel" aria-labelledby="count">
                                    @include('back.statistics.orders.filter-tabs')

                                    <div id="order-counts-chart" class="chart-area" style="min-height: 445px;" data-min-height="445px" data-action="{{ route('admin.statistics.orderCounts') }}"></div>

                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom">کل سفارشات : <span class="orders-total"></span></span>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom">میانگین سفارشات : <span class="orders-avg"></span></span>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom"> سفارشات موفق: <span class="orders-success"></span></span>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom"> سفارشات ناموفق: <span class="orders-fail"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="order-users" role="tabpanel" aria-labelledby="user">
                                    @include('back.statistics.orders.filter-tabs')

                                    <div id="order-users-chart" class="chart-area" style="min-height: 445px;" data-min-height="445px" data-action="{{ route('admin.statistics.orderUsers') }}"></div>

                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom">کل سفارشات : <span class="orders-total"></span></span>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom">میانگین سفارشات : <span class="orders-avg"></span></span>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom"> سفارشات موفق: <span class="orders-success"></span></span>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom"> سفارشات ناموفق: <span class="orders-fail"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="order-products" role="tabpanel" aria-labelledby="product">
                                    @include('back.statistics.orders.filter-tabs')

                                    <div id="order-products-chart" class="chart-area" style="min-height: 445px;" data-min-height="445px" data-action="{{ route('admin.statistics.orderProducts') }}"></div>

                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom">کل سفارشات : <span class="orders-total"></span></span>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom">میانگین سفارشات : <span class="orders-avg"></span></span>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom"> سفارشات موفق: <span class="orders-success"></span></span>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom"> سفارشات ناموفق: <span class="orders-fail"></span></span>
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

@include('back.partials.plugins', ['plugins' => ['apexcharts', 'persian-datepicker']])

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/statistics/orders.js') }}?v=2"></script>
@endpush
