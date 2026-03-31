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
                                    <li class="breadcrumb-item">مدیریت روش های ارسال
                                    </li>
                                    <li class="breadcrumb-item active">ایجاد تعرفه
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">ایجاد تعرفه جدید</h4>
                    </div>

                    <div id="main-card" class="card-content">
                        <div class="card-body">
                            <div class="col-12 col-md-10 offset-md-1">
                                <form class="form" id="tariff-create-form" action="{{ route('admin.tariffs.store') }}" data-redirect="{{ route('admin.tariffs.index', ['carrier' => $carrier]) }}" method="post">
                                    @csrf

                                    <input type="hidden" name="carrier_id" value="{{ $carrier->id }}">

                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>نوع منطقه ارسالی</label>
                                                    <select class="form-control" name="type">
                                                        <option value="within_province">درون استانی</option>
                                                        <option value="extra_province">برون استانی</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>حداکثر وزن (گرم)</label>
                                                    <input type="number" class="form-control" name="max_weight">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>هزینه ارسال (تومان)</label>
                                                    <input type="number" class="form-control amount-input" name="shipping_cost">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-12 text-right">
                                                <button type="submit" class="btn btn-primary mb-1 waves-effect waves-light">ایجاد تعرفه</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

@endsection

@include('back.partials.plugins', ['plugins' => ['jquery.validate']])

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/tariffs/create.js') }}"></script>
@endpush
