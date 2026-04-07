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
                                    <li class="breadcrumb-item active">ایمپورت محصولات از اکسل</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title mb-0">مرحله ۱: آپلود فایل و دریافت پیش‌نمایش</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="{{ route('admin.products.import.preview') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>فایل اکسل</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="excel_file" required>
                                            <label class="custom-file-label">xlsx/xls/csv</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>رفتار با داده تکراری</label>
                                        <select class="form-control" name="duplicate_strategy" required>
                                            @foreach($duplicateStrategies as $key => $label)
                                                <option value="{{ $key }}" {{ old('duplicate_strategy', data_get($state, 'options.duplicate_strategy', 'skip')) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5 d-flex align-items-center mt-2 mt-md-0">
                                        <div class="custom-control custom-checkbox mr-2">
                                            <input type="checkbox" id="create_missing_taxonomy" class="custom-control-input" name="create_missing_taxonomy" value="1" {{ old('create_missing_taxonomy', data_get($state, 'options.create_missing_taxonomy')) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="create_missing_taxonomy">ایجاد خودکار دسته/برندهای جدید</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" id="import_images" class="custom-control-input" name="import_images" value="1" {{ old('import_images', data_get($state, 'options.import_images')) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="import_images">دانلود تصاویر از URL</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <button class="btn btn-outline-primary" type="submit">نمایش پیش‌نمایش</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @if($state)
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title mb-0">مرحله ۲: مپینگ ستون‌ها و اجرای ایمپورت</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form action="{{ route('admin.products.import.run') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="import_token" value="{{ $state['importToken'] }}">
                                    <input type="hidden" name="duplicate_strategy" value="{{ data_get($state, 'options.duplicate_strategy', 'skip') }}">
                                    <input type="hidden" name="create_missing_taxonomy" value="{{ data_get($state, 'options.create_missing_taxonomy', 0) }}">
                                    <input type="hidden" name="import_images" value="{{ data_get($state, 'options.import_images', 0) }}">

                                    <div class="row">
                                        @foreach($fields as $field => $label)
                                            <div class="col-md-4 mb-1">
                                                <label>{{ $label }}</label>
                                                <select class="form-control" name="mapping[{{ $field }}]" {{ in_array($field, ['title', 'price']) ? 'required' : '' }}>
                                                    <option value="">انتخاب ستون...</option>
                                                    @foreach($state['headers'] as $header)
                                                        <option value="{{ $header }}" {{ data_get($state, 'mapping.' . $field) == $header ? 'selected' : '' }}>{{ $header }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endforeach
                                    </div>

                                    <button type="submit" class="btn btn-success mt-2">شروع ایمپورت</button>
                                </form>

                                <hr>

                                <h5>نمونه داده فایل</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                        <tr>
                                            @foreach($state['headers'] as $header)
                                                <th>{{ $header }}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($state['sampleRows'] as $sample)
                                            <tr>
                                                @foreach($state['headers'] as $header)
                                                    <td>{{ data_get($sample, $header) }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @if(data_get($state, 'result'))
                                    <hr>
                                    <h5>نتیجه ایمپورت</h5>
                                    <ul>
                                        <li>کل ردیف‌ها: {{ $state['result']['total'] }}</li>
                                        <li>ایجاد شده: {{ $state['result']['created'] }}</li>
                                        <li>به‌روزرسانی شده: {{ $state['result']['updated'] }}</li>
                                        <li>رد شده: {{ $state['result']['skipped'] }}</li>
                                        <li>ناموفق: {{ $state['result']['failed'] }}</li>
                                    </ul>

                                    @if(count($state['result']['errors']))
                                        <h6>خطاها</h6>
                                        <ul>
                                            @foreach($state['result']['errors'] as $error)
                                                <li>ردیف {{ $error['row'] }}: {{ $error['message'] }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
