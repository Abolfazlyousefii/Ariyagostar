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
                                    <li class="breadcrumb-item active">راهنمای سایز</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="main-card" class="content-body">
                <form id="sizetype-form" action="{{ route('admin.sizetypes.store') }}" data-redirect="{{ route('admin.sizetypes.index') }}" class="form"  method="post">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">

                            <div id="sizetypes-card" class="card">

                                <div class="card-content">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>عنوان</label>
                                                            <input class="form-control" name="title" placeholder="مثلا پیراهن" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div id="sizes-area">

                                                            <div class="row mt-2 sizes-group">

                                                                <div class="all-sizes col-12">
                                                                    <div class="single-size">
                                                                        <div class="row">
                                                                            <div class="col-md-10 form-group">
                                                                                <input type="text" class="form-control" name="sizes[]" placeholder="مثال: قد" value="" required>
                                                                            </div>
                                                                            <div class="col-md-1">
                                                                                <button type="button" class="btn btn-flat-danger waves-effect waves-light remove-size custom-padding"><i class="feather icon-minus"></i></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 text-center">
                                                                    <button type="button" class="btn btn-flat-success waves-effect waves-light add-size">افزودن مشخصه سایز</button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>توضیحات</label>
                                                    <textarea id="description" name="description" rows="5" class="form-control"></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-12 text-center mt-4">
                                                    <button type="submit" class="btn btn-outline-success waves-effect waves-light">ذخیره تغییرات</button>
                                                </div>
                                            </div>

                                        </div>
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

@include('back.partials.plugins', ['plugins' => ['jquery-ui', 'jquery.validate', 'jquery-ui-sortable', 'ckeditor']])

@push('scripts')
    <script>
        let sizeCount = 0;
    </script>

    <script src="{{ asset('back/assets/js/pages/sizetypes/edit.js') }}"></script>
@endpush
