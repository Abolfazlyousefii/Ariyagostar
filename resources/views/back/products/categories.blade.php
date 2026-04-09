@extends('back.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('back/app-assets/plugins/nestable2/jquery.nestable.min.css') }}">
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
                                    <li class="breadcrumb-item">مدیریت</li>
                                    <li class="breadcrumb-item">مدیریت محصولات</li>
                                    <li class="breadcrumb-item active">دسته‌بندی‌ها</li>
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
                <section id="description" class="card">
                    <div class="card-header">
                        <h4 class="card-title">مدیریت دسته‌بندی‌ها</h4>
                    </div>
                    <div id="main-block" class="card-content">
                        <div class="card-body">
                            <div class="col-12 offset-xl-2">
                                <form id="create-category" action="{{ route('admin.categories.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <div class="row">
                                            <input type="hidden" name="type" value="productcat">
                                            <div class="col-md-5 col-sm-10 col-10">
                                                <input id="title" type="text" class="form-control" name="title" placeholder="افزودن دسته‌بندی جدید...">
                                            </div>
                                            <div class="col-2 px-0">
                                                <button type="submit" class="btn btn-success waves-effect waves-light">افزودن</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div id="bulk-actions" class="d-flex align-items-center justify-content-between flex-wrap mt-3" style="display: none;">
                                    <div class="form-check form-check-inline mb-0">
                                        <input class="form-check-input" type="checkbox" id="select-all-categories">
                                        <label class="form-check-label" for="select-all-categories">انتخاب همه</label>
                                    </div>
                                    <div class="mt-1 mt-md-0">
                                        <span id="selected-count" class="text-muted mr-1">0 مورد انتخاب شده</span>
                                        <button type="button" id="bulk-delete-trigger" class="btn btn-danger waves-effect waves-light" disabled>
                                            <i class="fa fa-trash ml-50"></i>
                                            حذف گروهی
                                        </button>
                                    </div>
                                </div>

                                <div class="dd mt-4">
                                    <ol class="dd-list">
                                        @foreach ($categories as $category)
                                            @include('back.partials.child_category', ['child_category' => $category, 'enableBulkDelete' => true])
                                        @endforeach
                                    </ol>
                                </div>
                                <p class="card-text mt-3">
                                    <i class="feather icon-info mr-1 align-middle"></i>
                                    <span class="text-info">برای ایجاد زیر دسته، دسته‌بندی مورد نظر را به سمت چپ بکشید.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel19" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    با حذف این دسته‌بندی تمامی زیر دسته‌های آن حذف خواهند شد، آیا برای حذف مطمئن هستید؟
                </div>
                <form action="" method="POST" id="delete-form">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">خیر</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">بله حذف شود</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="modal-bulk-delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تأیید حذف گروهی</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">دسته‌بندی‌های انتخاب‌شده حذف می‌شوند. اگر هر دسته یا زیر‌دسته به محصولی متصل باشد حذف نخواهد شد.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">انصراف</button>
                    <button type="button" id="confirm-bulk-delete" class="btn btn-danger waves-effect waves-light">بله، حذف شود</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px; width: 90vw;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">ویرایش دسته‌بندی</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit-form" action="#">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                        <!-- محتوای فرم اینجا قرار می‌گیرد -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">انصراف</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">ذخیره</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('back/app-assets/plugins/nestable2/jquery.nestable.min.js') }}"></script>
    <script src="{{ asset('back/app-assets/plugins/jquery-tagsinput/jquery.tagsinput.min.js') }}"></script>
    <script src="{{ asset('back/app-assets/plugins/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('back/app-assets/plugins/ckeditor/ckeditor.js') }}"></script>

    <script>
        var maxDepth = 10;
        var deleteRouteBase = '{{ route("admin.products.categories.destroy", "") }}';
        var bulkDeleteRoute = '{{ route("admin.products.categories.bulkDestroy") }}';
        var BASE_URL = '{{ url('/') }}';
        var adminRoutePrefix = '{{ admin_route_prefix() }}';
    </script>

    <script src="{{ asset('back/assets/js/pages/categories.js') }}"></script>
@endpush
