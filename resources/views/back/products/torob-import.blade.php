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
                                    <li class="breadcrumb-item">مدیریت</li>
                                    <li class="breadcrumb-item">مدیریت محصولات</li>
                                    <li class="breadcrumb-item active">آپلود فایل اکسل ترب</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="main-card" class="content-body">
                <form action="{{ route('admin.product.torobUpload') }}" data-redirect="{{ route('admin.product.torobPrices') }}" class="form ajax-form" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-4">
                                        <fieldset class="form-group">
                                            <label>فایل اکسل <small>(از پنل ترب دانلود کنید)</small></label>
                                            <div class="custom-file">
                                                <input id="file" type="file" name="excel_file" class="custom-file-input">
                                                <label class="custom-file-label" for="file"></label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-outline-success waves-effect waves-light">آپلود</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </form>

            </div>

        </div>
    </div>
@endsection
