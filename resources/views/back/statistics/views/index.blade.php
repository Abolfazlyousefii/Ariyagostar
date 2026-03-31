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
                                    <li class="breadcrumb-item active">بازدیدها
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
                            <ul class="nav nav-tabs mb-2" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-toggle="tab" href="#view-counts" role="tab" aria-controls="view-counts" aria-selected="true">
                                      تعداد بازدیدها
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-toggle="tab" href="#viewer-counts" role="tab" aria-controls="viewer-counts" aria-selected="true">
                                      تعداد بازدیدگنندگان
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="view-counts" role="tabpanel" aria-labelledby="value">
                                    @include('back.statistics.views.filter-tabs')

                                    <div id="view-counts-chart" class="chart-area" style="min-height: 445px;" data-min-height="445px" data-action="{{ route('admin.statistics.viewCounts') }}"></div>

                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom">کل بازدیدها : <span class="views-total"></span></span>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom">میانگین : <span class="views-avg"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="viewer-counts" role="tabpanel" aria-labelledby="value">
                                    @include('back.statistics.views.filter-tabs')

                                    <div id="viewer-counts-chart" class="chart-area" style="min-height: 445px;" data-min-height="445px" data-action="{{ route('admin.statistics.viewerCounts') }}"></div>

                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom">کل بازدیدها : <span class="viewers-total"></span></span>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <span class="border-bottom">میانگین : <span class="viewers-avg"></span></span>
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
    <script src="{{ asset('back/assets/js/pages/statistics/views.js') }}?v=1"></script>
@endpush
