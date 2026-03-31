@extends('back.layouts.master')

@push('styles')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('back/app-assets/plugins/nestable2/jquery.nestable.min.css') }}">
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
                                    <li class="breadcrumb-item active">مدیریت منوها
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        <div id="save-changes" class="spinner-border text-success" role="status" style="display: none">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <!-- menus -->
                <section id="description" class="card">
                    <div class="card-header">
                        <h4 class="card-title">مدیریت منوها</h4>
                        <button class="btn btn-success" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus mr-1"></i> افزودن منوی جدید</button>
                    </div>
                    <div id="main-block" class="card-content">
                        <div class="card-body">
                            <!-- menus -->
                            <div class="col-12 offset-xl-2">

                                <!-- List menus -->
                                <div class="dd my-5">
                                    <ol class="dd-list">
                                        @foreach ($menus as $menu)
                                            @include('back.menus.partials.child_menu', ['child_menu' => $menu])
                                        @endforeach
                                    </ol>
                                </div>
                                <!-- END List menus -->
                                <p class="card-text mt-3"><i class="feather icon-info mr-1 align-middle"></i><span class="text-info">برای ایجاد زیر منو، منو مورد نظر را به  سمت چپ بکشید.</span></p>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade text-left" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">ایجاد منوی جدید </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="create-menu" action="#">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>نوع منو</label>
                                    <select class="form-control" id="menu-type" name="type">
                                        <option value="normal">منوی معمولی</option>
                                        <option value="category">منوی دسته بندی </option>
                                        <option value="static">منوی ثابت </option>
                                        <option value="megamenu">مگامنو </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12" id="menu-title-div">
                                <div class="form-group">
                                    <label>عنوان</label>
                                    <input type="text" class="form-control" name="title">
                                </div>
                            </div>
                            <div class="col-12" id="menu-link-div">
                                <div class="form-group">
                                    <label>لینک</label>
                                    <input type="text" class="form-control create-menu-link ltr" name="link">
                                </div>
                            </div>

                            <div class="col-12" id="menu-category-div" style="display: none;">
                                <div class="form-group">
                                    <label>عنوان</label>
                                    <input type="text" class="form-control" name="category_title">
                                    <p class="text-muted">این فیلد اختیاری است</p>
                                </div>

                                <div class="form-group">
                                    <label>انتخاب دسته بندی</label>
                                    <select class="form-control" id="category" name="category">

                                        @foreach ($categories as $key => $categoryGroup)
                                            <optgroup label="{{ category_group($key) }}">
                                                @foreach ($categoryGroup as $category)
                                                    <option value="{{ $category->id }}">{{ $category->full_title }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group">
                                    <fieldset class="checkbox">
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox" name="children" checked>
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">اضافه کردن زیر دسته ها</span>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="col-12" id="menu-static-div" style="display: none;">
                                <div class="form-group">
                                    <label>انتخاب منو</label>
                                    <select class="form-control" id="static" name="static">
                                        @foreach (config('general.static_menus') as $key => $static_menu)
                                            <option value="{{ $key }}">{{ $static_menu['title'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">انصراف</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">ذخیره</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Add Modal -->

    <!-- Delete Modal -->
    <div class="modal fade text-left" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel19" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    با حذف این منو تمامی زیر منو های آن حذف خواهند شد، آیا برای حذف
                            مطمئن هستید؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">خیر</button>
                    <button id="confirm-delete" type="button" class="btn btn-danger waves-effect waves-light">بله حذف شود</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Delete Modal -->

    <!-- Edit Modal -->
    <div class="modal fade text-left" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">ویرایش منو </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit-form" action="#">
                    <div class="modal-body">
                        <div class="row">
                            @method('put')
                            <div class="col-12 d-none">
                                <div class="form-group">
                                    <label>نوع منو</label>
                                    <select class="form-control" id="edit-menu-type" name="type">
                                        <option value="normal">منوی معمولی</option>
                                        <option value="category">منوی دسته بندی </option>
                                        <option value="static">منوی ثابت </option>
                                        <option value="megamenu">مگامنو </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12" id="edit-menu-title-div">
                                <div class="form-group">
                                    <label>عنوان</label>
                                    <input type="text" class="form-control" name="title">
                                </div>
                            </div>
                            <div class="col-12 not-static" id="edit-menu-link-div">
                                <div class="form-group">
                                    <label>لینک</label>
                                    <input type="text" class="form-control edit-menu-link ltr" name="link">
                                </div>
                            </div>

                            <div class="col-12 not-static" id="edit-menu-category-div" style="display: none;">
                                <div class="form-group">
                                    <label>عنوان</label>
                                    <input type="text" class="form-control" name="category_title">
                                    <p class="text-muted">این فیلد اختیاری است</p>
                                </div>

                                <div class="form-group">
                                    <label>انتخاب دسته بندی</label>
                                    <select class="form-control" id="edit-category" name="category">
                                        @foreach ($categories as $key => $categoryGroup)
                                            <optgroup label="{{ category_group($key) }}">
                                                @foreach ($categoryGroup as $category)
                                                    <option value="{{ $category->id }}">{{ $category->full_title }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <fieldset class="checkbox">
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox" name="children" checked>
                                            <span class="vs-checkbox">
                                                <span class="vs-checkbox--check">
                                                    <i class="vs-icon feather icon-check"></i>
                                                </span>
                                            </span>
                                            <span class="">اضافه کردن زیر دسته ها</span>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="col-12" id="edit-menu-static-div" style="display: none;">
                                <div class="form-group">
                                    <label>انتخاب منو</label>
                                    <select class="form-control" id="edit-static" name="static">
                                        @foreach (config('general.static_menus') as $key => $static_menu)
                                            <option value="{{ $key }}">{{ $static_menu['title'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">انصراف</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">ذخیره</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Edit Modal -->

@endsection

@push('scripts')
    <!-- Page JS Plugins -->
    <script src="{{ asset('back/app-assets/plugins/nestable2/jquery.nestable.min.js') }}"></script>
    <script src="{{ asset('back/app-assets/plugins/jquery-ui/jquery-ui.js') }}"></script>

    <!-- Page JS Code -->
    <script>
        var pages =  [
            @foreach($pages as $page)
                "/pages/{{ $page }}",
            @endforeach
        ];

        var megaMenuDepth = {{ config('front.mega_menu_depth') ?: 3 }};
    </script>
    <script src="{{ asset('back/assets/js/pages/menus.js') }}"></script>
@endpush
