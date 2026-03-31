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
                                    <li class="breadcrumb-item active">لیست بکاپ ها
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12">
                    <div class="form-group breadcrum-right">
                        <button data-action="{{ route('admin.backups.create') }}" id="create-backup-btn" class="btn btn-primary waves-effect waves-light"><i class="feather icon-plus"></i> ایجاد بکاپ جدید</button>
                    </div>
                </div>
            </div>
            <div class="content-body">

                @if($backups->count())
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست بکاپ ها</h4>
                        </div>
                        <div class="card-content" id="main-card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>نام فایل</th>
                                                <th>تاریخ ایجاد</th>
                                                <th>اندازه فایل</th>
                                                <th class="text-center">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($backups->sortByDesc('date') as $backup)
                                                <tr id="backup-{{ $backup['name'] }}-tr">
                                                    <td class="ltr">{{ $backup['name'] }}</td>
                                                    <td class="ltr">{{ jdate($backup['date']) }}</td>
                                                    <td class="ltr">{{ $backup['size'] }}</td>

                                                    <td class="text-center">

                                                        <a href="{{ route('admin.backups.download', ['backup' => $backup['name']]) }}" class="btn btn-success mr-1 waves-effect waves-light"><i class="feather icon-download"></i> دانلود</a>
                                                        <button type="button" data-backup="{{ $backup['name'] }}" class="btn btn-danger mr-1 waves-effect waves-light btn-delete"  data-toggle="modal" data-target="#delete-modal">حذف</button>

                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>

                @else
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست بکاپ ها</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="card-text">
                                    <p>چیزی برای نمایش وجود ندارد!</p>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

            </div>
        </div>
    </div>

    {{-- delete backup modal --}}
    <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel19" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    با حذف بکاپ دیگر قادر به بازیابی آن نخواهید بود
                </div>
                <div class="modal-footer">
                    <form action="#" id="backup-delete-form">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">خیر</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">بله حذف شود</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/backups/index.js') }}"></script>
@endpush
