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
                                <li class="breadcrumb-item">مدیریت قالب ها
                                </li>
                                <li class="breadcrumb-item active">افزودن قالب
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="content-body">
            <!-- Description -->
            <section class="card">
                <div class="card-header">
                    <h4 class="card-title">افزودن قالب جدید</h4>
                </div>

                <div id="main-card" class="card-content">
                    <div class="card-body">
                        <div class="col-12 col-md-10 offset-md-1">
                            <form class="form" id="theme-create-form" action="{{ route('admin.themes.store') }}" method="post">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <fieldset class="form-group">
                                            <label>انتخاب فایل قالب</label>
                                            <div class="custom-file">
                                                <input id="file" type="file"  accept=".zip" name="file" class="custom-file-input" required>
                                                <label class="custom-file-label" for="file"></label>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="row">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">افزودن قالب</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </section>
            <div id="form-progress" class="progress progress-bar-success progress-xl" style="display: none;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:0%">0%</div>
            </div>
            <!--/ Description -->

        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('back/app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('back/app-assets/plugins/jquery-validation/localization/messages_fa.min.js') }}"></script>
    <script src="{{ asset('back/assets/js/pages/themes/create.js') }}"></script>
@endpush
