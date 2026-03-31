@extends('back.layouts.master')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('back/app-assets/plugins/jquery-tagsinput/jquery.tagsinput.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('back/app-assets/plugins/jquery-ui/jquery-ui.css') }}">
@endpush

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
                                <li class="breadcrumb-item">مدیریت صفحات
                                </li>
                                <li class="breadcrumb-item active">ویرایش صفحه
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="content-body">
            <!-- Description -->
            <section id="description" class="card">
                <div class="card-header">
                    <h4 class="card-title">ویرایش صفحه</h4>
                </div>
                
                <div id="main-card" class="card-content">
                    <div class="card-body">
                        <div class="col-12 col-md-10 offset-md-1">
                            <form class="form" id="page-edit-form" action="{{ route('admin.pages.update', ['page' => $page]) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label>عنوان</label>
                                                <input type="text" class="form-control" name="title" value="{{ $page->title }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">محتوا</label>
                                                <textarea id="content" class="form-control" rows="3" name="content">{{ $page->content }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <fieldset class="form-group">
                                                <label>کلمات کلیدی</label>
                                                <input id="tags" type="text" name="tags" class="form-control" value="{{ $page->getTags }}">
                                            </fieldset>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <fieldset class="checkbox">
                                                <div class="vs-checkbox-con vs-checkbox-primary pt-3">
                                                    <input type="checkbox" name="published" {{ $page->published ? 'checked' : '' }}>
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span>انتشار صفحه؟</span>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">ویرایش صفحه</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <!--/ Description -->
            
        </div>
    </div>
</div>

@endsection

@push('scripts') 
        <script src="{{ asset('back/app-assets/plugins/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('back/app-assets/plugins/jquery-tagsinput/jquery.tagsinput.min.js') }}"></script>
        <script src="{{ asset('back/app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('back/app-assets/plugins/jquery-ui/jquery-ui.js') }}"></script>

        <script src="{{ asset('back/assets/js/pages/pages/edit.js') }}"></script>
@endpush