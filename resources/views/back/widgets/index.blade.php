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
                                    <li class="breadcrumb-item">قالب ها
                                    </li>
                                    <li class="breadcrumb-item active">مدیریت صفحه اصلی</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12">
                    <div class="form-group breadcrum-right">
                        <a href="{{ route('admin.widgets.create') }}" class="btn-icon btn btn-success"><i class="feather icon-plus mr-1"></i> ایجاد ابزارک</a>
                    </div>
                </div>
            </div>
            <div class="content-body">

                @if($widgets->count())
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">مدیریت صفحه اصلی</h4>
                        </div>
                        <div class="card-content" id="main-card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ردیف</th>
                                                <th>عنوان</th>
                                                <th>نوع ابزارک</th>
                                                <th class="text-center">وضعیت</th>
                                                <th class="text-center">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody id="widgets-sortable" data-action="{{ route('admin.widgets.sort') }}">
                                            @foreach ($widgets as $widget)
                                                <tr id="widget-{{ $widget->id }}">
                                                    <td class="text-center draggable-handler">
                                                        <div class="fonticon-wrap"><i class="feather icon-move"></i></div>
                                                    </td>
                                                    <td>{{ $widget->title }}</td>
                                                    <td>{{ $widget->type() }}</td>
                                                    <td class="text-center">
                                                        @if($widget->is_active)
                                                            <div class="badge badge-pill badge-success badge-md">فعال</div>
                                                        @else
                                                            <div class="badge badge-pill badge-danger badge-md">غیر فعال</div>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.widgets.edit', ['widget' => $widget]) }}" class="btn btn-warning waves-effect waves-light">ویرایش</a>
                                                        <button type="button" data-action="{{ route('admin.widgets.destroy', ['widget' => $widget]) }}" class="btn btn-danger waves-effect waves-light btn-delete"  data-toggle="modal" data-target="#delete-modal">حذف</button>
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
                            <h4 class="card-title">مدیریت صفحه اصلی</h4>
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

    {{-- delete widget modal --}}
    <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel19" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    با حذف ابزارک دیگر قادر به بازیابی آن نخواهید بود
                </div>
                <div class="modal-footer">
                    <form action="#" id="widget-delete-form">
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

@include('back.partials.plugins', ['plugins' => ['jquery-ui-sortable']])

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/widgets/index.js') }}"></script>
@endpush
