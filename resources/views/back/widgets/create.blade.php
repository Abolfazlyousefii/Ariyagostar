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
                                    <li class="breadcrumb-item">قالب ها
                                    </li>
                                    <li class="breadcrumb-item active">ایجاد ابزارک</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">ایجاد ابزارک جدید</h4>
                    </div>

                    <div id="main-card" class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-8">
                                    <form class="form" id="widget-create-form" action="{{ route('admin.widgets.store') }}" data-redirect="{{ route('admin.widgets.index') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-body">
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>نوع ابزارک</label>
                                                        <select id="widget-key" name="key" class="form-control" required>
                                                            <option value="">انتخاب کنید</option>
                                                            @foreach (config('front.home-widgets') as $key => $template_widget)
                                                                <option value="{{ $key }}" data-image="{{ isset($template_widget['image']) ? theme_asset($template_widget['image']) : '' }}" data-action="{{ route('admin.widgets.template', ['key' => $key]) }}">{{ $template_widget['title'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>عنوان ابزارک</label>
                                                        <input type="text" class="form-control" name="title" required>
                                                    </div>
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
                                            </div>
                                            <div id="template">
                                                <div class="row">

                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">ایجاد ابزارک</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <img id="widget-image" src="" alt="widget" class="w-100" style="display: none;">
                                </div>
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
    <script src="{{ asset('back/assets/js/pages/widgets/create.js') }}"></script>
@endpush
