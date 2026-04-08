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
                                    <li class="breadcrumb-item active">ایمپورت محصولات</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section id="main-card" class="card">
                    <div class="card-header">
                        <h4 class="card-title">ایمپورت از فایل پردازش‌شده</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="alert alert-primary mb-2">
                                <p class="mb-1"><strong>فرمت مورد نیاز ستون‌ها:</strong> product_id, product_name, categories</p>
                                <p class="mb-0">برای چند دسته‌بندی می‌توانید از جداکننده‌های <code>,</code> یا <code>;</code> یا <code>|</code> استفاده کنید. برای ساخت سلسله‌مراتب از <code>></code> یا <code>/</code> استفاده کنید.</p>
                                <a class="btn btn-sm btn-outline-primary mt-1" href="{{ route('admin.products.import.sample') }}">دانلود فایل نمونه</a>
                            </div>

                            <form action="{{ route('admin.products.import.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-5">
                                        <fieldset class="form-group">
                                            <label>فایل اکسل/CSV</label>
                                            <div class="custom-file">
                                                <input id="file" type="file" name="excel_file" class="custom-file-input @error('excel_file') is-invalid @enderror" required>
                                                <label class="custom-file-label" for="file"></label>
                                            </div>
                                            @error('excel_file')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </fieldset>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success waves-effect waves-light">شروع ایمپورت</button>
                            </form>

                            @if (session('import_result'))
                                @php($result = session('import_result'))
                                <hr>
                                <h5 class="mb-1">نتیجه ایمپورت</h5>
                                <ul class="list-unstyled">
                                    <li>تعداد کل ردیف‌ها: <strong>{{ $result['total_rows'] ?? 0 }}</strong></li>
                                    <li>محصولات جدید: <strong>{{ $result['imported'] ?? 0 }}</strong></li>
                                    <li>محصولات بروزرسانی‌شده: <strong>{{ $result['updated'] ?? 0 }}</strong></li>
                                    <li>ردیف‌های ردشده: <strong>{{ $result['failed'] ?? 0 }}</strong></li>
                                    <li>ردیف‌های نادیده‌گرفته‌شده: <strong>{{ $result['skipped'] ?? 0 }}</strong></li>
                                </ul>

                                @if (!empty($result['errors']))
                                    <div class="alert alert-warning mb-0">
                                        <p class="mb-1"><strong>خطاها:</strong></p>
                                        <ul class="mb-0 pl-2">
                                            @foreach ($result['errors'] as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

