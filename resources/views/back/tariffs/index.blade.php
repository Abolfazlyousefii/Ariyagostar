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
                                    <li class="breadcrumb-item">مدیریت روش های ارسال
                                    </li>
                                    <li class="breadcrumb-item active">لیست تعرفه ها
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">لیست تعرفه ها</h4>
                        <div>
                            <a href="{{ route('admin.tariffs.create', ['carrier' => $carrier]) }}" class="btn btn-info waves-effect waves-light"><i class="feather icon-plus"></i> ایجاد تعرفه</a>
                        </div>
                    </div>
                    <div class="card-content" id="main-card">
                        <div class="card-body">
                            @if ($tariffs->count())
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>ردیف</th>
                                                <th>نوع منطقه ارسالی</th>
                                                <th>حداکثر وزن (گرم)</th>
                                                <th>هزینه ارسال (تومان)</th>
                                                <th class="text-center">عملیات</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($tariffs as $tariff)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $tariff->type() }}</td>
                                                    <td>{{ number_format($tariff->max_weight) }}</td>
                                                    <td>{{ number_format($tariff->shipping_cost) }}</td>

                                                    <td class="text-center">
                                                        <a href="{{ route('admin.tariffs.edit', ['tariff' => $tariff]) }}" class="btn btn-warning waves-effect waves-light">ویرایش</a>
                                                        <button type="button" data-action="{{ route('admin.tariffs.destroy', ['tariff' => $tariff]) }}" class="btn btn-danger waves-effect waves-light btn-delete"  data-toggle="modal" data-target="#delete-modal">حذف</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="card-text">
                                    <p>چیزی برای نمایش وجود ندارد!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>

                {{ $tariffs->appends(request()->except('page'))->links() }}

            </div>
        </div>
    </div>

    {{-- delete tariff modal --}}
    <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel19" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    آیا میخواهید این تعرفه را حذف کنید؟
                </div>
                <div class="modal-footer">
                    <form action="#" id="tariff-delete-form">
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
    <script src="{{ asset('back/assets/js/pages/tariffs/index.js') }}"></script>
@endpush
