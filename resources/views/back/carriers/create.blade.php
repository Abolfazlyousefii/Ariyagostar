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
                                    <li class="breadcrumb-item">مدیریت حمل و نقل
                                    </li>
                                    <li class="breadcrumb-item active">روش ارسال جدید
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
                        <h4 class="card-title">روش ارسال جدید</h4>
                    </div>

                    <div id="main-card" class="card-content">
                        <div class="card-body">
                            <div class="col-12 col-md-12">
                                <form class="form" id="carrier-create-form" action="{{ route('admin.carriers.store') }}" data-redirect="{{ route('admin.carriers.index') }}" method="post">
                                    @csrf

                                    <div class="form-body">
                                        <div class="nav-vertical">
                                            <ul class="nav nav-tabs nav-left flex-column" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="baseVerticalLeft-tab1" data-toggle="tab" aria-controls="tabVerticalLeft1" href="#tabVerticalLeft1" role="tab" aria-selected="true">اطلاعات کلی</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="baseVerticalLeft-tab2" data-toggle="tab" aria-controls="tabVerticalLeft2" href="#tabVerticalLeft2" role="tab" aria-selected="false">مناطق و هزینه ها</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tabVerticalLeft1" role="tabpanel" aria-labelledby="baseVerticalLeft-tab1">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>عنوان</label>
                                                                    <input type="text" class="form-control" name="title">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <fieldset class="form-group">
                                                                    <label>تصویر</label>
                                                                    <div class="custom-file">
                                                                        <input id="image" type="file" accept="image/*" name="image" class="custom-file-input">
                                                                        <label class="custom-file-label" for="image"></label>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>وضعیت</label>
                                                                    <select name="is_active" class="form-control">
                                                                        <option value="1">فعال</option>
                                                                        <option value="0">غیر فعال</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>زمان انتظار</label>
                                                                    <input type="text" class="form-control" name="waiting_time">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>حداکثر وزن بسته (گرم)</label>
                                                                    <input type="number" class="form-control" name="max_package_weight">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>حداقل وزن بسته (گرم)</label>
                                                                    <input type="number" class="form-control" name="min_package_weight">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>توضیحات</label>
                                                                    <textarea class="form-control" name="description" rows="3"></textarea>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabVerticalLeft2" role="tabpanel" aria-labelledby="baseVerticalLeft-tab2">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>استان فروشگاه</label>
                                                                    <select id="province" data-action="{{ route('provinces.get-cities') }}"  name="province_id" class="form-control">
                                                                        <option value="">انتخاب کنید</option>

                                                                        @foreach ($provinces as $province)
                                                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>شهر فروشگاه</label>
                                                                    <select id="city" name="city_id" class="form-control">
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <fieldset class="checkbox">
                                                                    <label for="">پس کرایه</label>
                                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                                        <input type="checkbox" name="carrige_forward">
                                                                        <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                        <span>آیا کرایه پس از ارسال مشخص میشود؟</span>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>ارسال رایگان برای وزن های بزرگتر از (گرم)</label>
                                                                    <input type="number" data-unit="گرم" class="form-control amount-input" name="free_shipping_weight">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>ارسال رایگان برای مبالغ بزرگتر از</label>
                                                                    <input type="number" class="form-control amount-input" name="free_shipping_price">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>هزینه اضافی برای بارهای سنگین تر (به ازای هر کیلوگرم)</label>
                                                                    <input type="number" class="form-control amount-input" name="extra_cost">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>نوع شهرهای تحت پوشش</label>
                                                                    <select name="covered_cities" class="form-control">
                                                                        <option value="all">همه</option>
                                                                        <option value="select_city">انتخاب شهر</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div id="included-cities-container" class="col-md-4">
                                                                <label>شهرهای تحت پوشش</label>
                                                                <input type="text" class="form-control" id="included-cities" placeholder="انتخاب کنید..." autocomplete="off"/>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-primary mb-1 waves-effect waves-light">ایجاد روش ارسال</button>
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

@include('back.partials.plugins', ['plugins' => ['jquery.validate', 'combo-tree']])

@push('scripts')
    <script>
        var provinces = {!! json_encode($provinces) !!};
        var selected_cities = [];
    </script>

    <script src="{{ asset('back/assets/js/pages/carriers/all.js') }}"></script>
    <script src="{{ asset('back/assets/js/pages/carriers/create.js') }}"></script>
@endpush
