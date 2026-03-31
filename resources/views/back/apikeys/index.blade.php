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
                                    <li class="breadcrumb-item">دیگر
                                    </li>
                                    <li class="breadcrumb-item active">لیست کلیدهای وب سرویس
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12">
                    <div class="form-group breadcrum-right">
                        <a href="{{ route('admin.apikeys.create') }}" class="btn btn-primary waves-effect waves-light"><i class="feather icon-plus"></i> ایجاد کلید جدید</a>
                    </div>
                </div>
            </div>
            <div class="content-body">

                @if($apikeys->count())
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست کلیدهای وب سرویس</h4>
                        </div>
                        <div class="card-content" id="main-card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>ردیف</th>
                                                <th class="text-center">توضیحات</th>
                                                <th class="text-center">کلید</th>
                                                <th class="text-center">وضعیت</th>
                                                <th class="text-center">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($apikeys as $apikey)
                                                <tr>

                                                    <td>
                                                        <div class="d-flex">
                                                            {{ $loop->iteration }}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">{{ $apikey->description ?: '-' }}</td>
                                                    <td class="d-flex">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <button class="btn btn-success" type="button">
                                                                    <i class="d-flex justify-content-center flex-column feather icon-file cursor-pointer copy_btn"></i>
                                                                </button>
                                                            </div>
                                                            <input onClick="this.select();" class="ltr apikey_key form-control" type="text" value="{{ $apikey->key }}" readonly>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        @if($apikey->is_active)
                                                            <div class="badge badge-pill badge-success badge-md">فعال</div>
                                                        @else
                                                            <div class="badge badge-pill badge-danger badge-md">غیر فعال</div>
                                                        @endif
                                                    </td>

                                                    <td class="text-center">

                                                        @can('apikeys.update')
                                                            <a href="{{ route('admin.apikeys.edit', ['apikey' => $apikey]) }}" class="btn btn-success mr-1 waves-effect waves-light">ویرایش</a>
                                                        @endcan

                                                        @can('apikeys.delete')
                                                            <button type="button" data-action="{{ route('admin.apikeys.destroy', ['apikey' => $apikey]) }}" class="btn btn-danger mr-1 waves-effect waves-light btn-delete"  data-toggle="modal" data-target="#delete-modal">حذف</button>
                                                        @endcan
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
                            <h4 class="card-title">لیست کلیدهای وب سرویس</h4>
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

    {{-- delete apikey modal --}}
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
                    با حذف کلید وب سرویس دیگر قادر به بازیابی آن نخواهید بود و کاربرانی که از این کلید برای اتصال به وب سرویس استفاده میکنند دیگر قادر به اتصال به وب سرویس نخواهند بود
                </div>
                <div class="modal-footer">
                    <form action="#" id="apikey-delete-form">
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
    <script src="{{ asset('back/assets/js/pages/apikeys/index.js') }}?v=2"></script>
@endpush
