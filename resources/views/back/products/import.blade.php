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
                                                <input id="excel_file" type="file" name="excel_file" class="custom-file-input @error('excel_file') is-invalid @enderror" accept=".xlsx,.xls,.csv,.txt">
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
                                    </div>
                                </div>
                            </form>
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
            </div>

        </div>
    </div>
@endsection
