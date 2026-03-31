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
                                    <li class="breadcrumb-item">مدیریت محصولات
                                    </li>
                                    <li class="breadcrumb-item active">لیست انواع سایز ها
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                @if($sizetypes->count())
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست انواع سایز ها</h4>
                            <a class="btn btn-success" href="{{ route('admin.sizetypes.create') }}">افزودن</a>
                        </div>

                        <div class="card-content" id="main-card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>نام</th>
                                                <th class="text-center">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sizetypes as $sizetype)
                                                <tr id="sizetype-{{ $sizetype->id }}-tr">
                                                    <td class="text-center">
                                                        {{ $sizetype->id }}
                                                    </td>
                                                    <td>{{ $sizetype->title }}</td>

                                                    <td class="text-center">
                                                        <a href="{{ route('admin.sizetypes.editValues', ['sizetype' => $sizetype]) }}" class="btn btn-warning waves-effect waves-light">مقادیر</a>
                                                        <a href="{{ route('admin.sizetypes.edit', ['sizetype' => $sizetype]) }}" class="btn btn-success waves-effect waves-light">ویرایش</a>
                                                        <button data-id="{{ $sizetype->id }}" data-action="{{ route('admin.sizetypes.destroy', ['sizetype' => $sizetype]) }}" type="button" class="btn btn-danger mr-1 waves-effect waves-light btn-delete"  data-toggle="modal" data-target="#delete-modal">حذف</button>
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
                            <h4 class="card-title">لیست انواع سایز ها</h4>
                            <a class="btn btn-success" href="{{route('admin.sizetypes.create')}}" role="button">افزودن</a>
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

                {{ $sizetypes->links() }}

            </div>
        </div>
    </div>

    {{-- delete post modal --}}
    <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    آیا میخواهید این مورد را حذف کنید؟
                </div>
                <div class="modal-footer">
                    <form action="#" id="sizetype-delete-form">
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
    <script src="{{ asset('back/assets/js/pages/sizetypes/index.js') }}"></script>
@endpush
