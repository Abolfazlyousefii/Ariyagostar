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
                                    <li class="breadcrumb-item active">ایمپورت اکسل محصولات</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="main-card" class="content-body">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="alert alert-info">
                                <h5 class="mb-50">راهنمای فایل ورودی</h5>
                                <p class="mb-50">فایل باید شامل ستون‌های <strong>product_id</strong>، <strong>product_name</strong> و <strong>categories</strong> باشد.</p>
                                <p class="mb-50">برای ستون categories می‌توانید چند دسته را با <strong>,</strong> یا <strong>|</strong> یا <strong>;</strong> جدا کنید.</p>
                                <a href="{{ route('admin.products.import.sample') }}" class="btn btn-sm btn-outline-primary mt-50">دانلود فایل نمونه</a>
                            </div>

                            <form action="{{ route('admin.products.import.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="excel_file">فایل اکسل / CSV</label>
                                            <div class="custom-file">
                                                <input id="excel_file" type="file" name="excel_file" class="custom-file-input @error('excel_file') is-invalid @enderror" accept=".xlsx,.xls,.csv">
                                                <label class="custom-file-label" for="excel_file">انتخاب فایل</label>
                                            </div>
                                            @error('excel_file')
                                                <small class="text-danger d-block mt-50">{{ $message }}</small>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-outline-success waves-effect waves-light">شروع ایمپورت</button>
                                        @can('products.delete')
                                            <button type="button" class="btn btn-outline-danger waves-effect waves-light mr-1" data-toggle="modal" data-target="#cleanup-imported-products-modal">
                                                حذف محصولات ایمپورت‌شده
                                            </button>
                                        @endcan
                                    </div>
                                </div>
                            </form>

                            @can('products.delete')
                                <div class="modal fade text-left" id="cleanup-imported-products-modal" tabindex="-1" role="dialog" aria-labelledby="cleanupImportedProductsModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h4 class="modal-title text-white" id="cleanupImportedProductsModalLabel">تأیید پاکسازی داده‌های ایمپورت</h4>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="mb-50">این عملیات غیرقابل بازگشت است.</p>
                                                <p class="mb-50">تمام محصولاتی که با ایمپورت اکسل ایجاد/به‌روزرسانی شده‌اند حذف می‌شوند.</p>
                                                <p class="mb-0">داده‌های دستی یا دسته‌بندی‌های اصلی سایت حذف نخواهند شد.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">انصراف</button>
                                                <form action="{{ route('admin.products.import.cleanup') }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">بله، پاکسازی انجام شود</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>

                @if(session('import_summary'))
                    @php($summary = session('import_summary'))
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <h5 class="mb-1">خلاصه نتیجه ایمپورت</h5>
                                <div class="row">
                                    <div class="col-md-3 mb-50"><strong>کل ردیف‌ها:</strong> {{ $summary['total_rows'] }}</div>
                                    <div class="col-md-3 mb-50 text-success"><strong>محصول جدید:</strong> {{ $summary['imported'] }}</div>
                                    <div class="col-md-3 mb-50 text-primary"><strong>محصول به‌روزرسانی‌شده:</strong> {{ $summary['updated'] }}</div>
                                    <div class="col-md-3 mb-50 text-warning"><strong>ردیف رد شده:</strong> {{ $summary['skipped'] }}</div>
                                    <div class="col-md-3 mb-50 text-danger"><strong>ردیف ناموفق:</strong> {{ $summary['failed'] }}</div>
                                </div>

                                @if(!empty($summary['failures']))
                                    <hr>
                                    <h6>خطاها</h6>
                                    <ul class="mb-0 pl-2">
                                        @foreach($summary['failures'] as $failure)
                                            <li>ردیف {{ $failure['row'] }}: {{ $failure['reason'] }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('cleanup_summary'))
                    @php($cleanupSummary = session('cleanup_summary'))
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <h5 class="mb-1">خلاصه پاکسازی داده‌های ایمپورت</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-50 text-danger"><strong>محصول حذف‌شده:</strong> {{ $cleanupSummary['deleted_products'] }}</div>
                                    <div class="col-md-4 mb-50 text-danger"><strong>رابط دسته‌بندی حذف‌شده:</strong> {{ $cleanupSummary['deleted_category_relations'] }}</div>
                                    <div class="col-md-4 mb-50 text-danger"><strong>دسته‌بندی اصلی محصول حذف‌شده:</strong> {{ $cleanupSummary['deleted_primary_category_links'] }}</div>
                                    <div class="col-md-4 mb-50 text-danger"><strong>دسته/زیر‌دسته ایمپورتی حذف‌شده:</strong> {{ $cleanupSummary['deleted_categories'] }}</div>
                                    <div class="col-md-4 mb-50 text-danger"><strong>متادیتای ایمپورت پاک‌شده:</strong> {{ $cleanupSummary['deleted_import_metadata'] }}</div>
                                    <div class="col-md-4 mb-50 text-success"><strong>محصول دستی حفظ‌شده:</strong> {{ $cleanupSummary['preserved_manual_products'] }}</div>
                                    <div class="col-md-4 mb-50 text-success"><strong>دسته‌بندی غیرایمپورت حفظ‌شده:</strong> {{ $cleanupSummary['preserved_existing_categories'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
