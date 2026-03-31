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
                                    <li class="breadcrumb-item">مدیریت صفحات
                                    </li>
                                    <li class="breadcrumb-item active">لیست صفحات
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                @if($pages->count())
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست صفحات</h4>
                        </div>
                        <div class="card-content" id="main-card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>عنوان</th>
                                                <th class="text-center">لینک</th>
                                                <th class="text-center">وضعیت</th>
                                                <th class="text-center">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pages as $page)
                                                <tr id="page-{{ $page->id }}-tr">

                                                    <td>
                                                        <div class="d-flex">
                                                            {{ $page->title }} <a href="{{ Route::has('front.pages.show') ? route('front.pages.show', ['page' => $page]) : '' }}" target="_blank"><i class="feather icon-external-link ml-1"></i></a>
                                                        </div>
                                                    </td>
                                                    <td class="d-flex">
                                                        @if (Route::has('front.pages.show'))
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <button class="btn btn-success" type="button">
                                                                        <i class="d-flex justify-content-center flex-column feather icon-file cursor-pointer copy_btn"></i>
                                                                    </button>
                                                                </div>
                                                                <input onClick="this.select();" class="ltr page_link form-control" type="text" value="{{ $page->link() }}" readonly>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if($page->published)
                                                            <div class="badge badge-pill badge-success badge-md">منتشر شده</div>
                                                        @else
                                                            <div class="badge badge-pill badge-danger badge-md">پیش نویس</div>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">

                                                        @can('pages.update')
                                                            <a href="{{ route('admin.pages.edit', ['page' => $page]) }}" class="btn btn-success mr-1 waves-effect waves-light">ویرایش</a>
                                                        @endcan

                                                        @can('pages.delete')
                                                            <button type="button" data-page="{{ $page->slug }}" data-id="{{ $page->id }}" class="btn btn-danger mr-1 waves-effect waves-light btn-delete"  data-toggle="modal" data-target="#delete-modal">حذف</button>
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
                            <h4 class="card-title">لیست صفحات</h4>
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
                {{ $pages->links() }}

            </div>
        </div>
    </div>

    {{-- delete page modal --}}
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
                    با حذف صفحه دیگر قادر به بازیابی آن نخواهید بود
                </div>
                <div class="modal-footer">
                    <form action="#" id="page-delete-form">
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
    <script src="{{ asset('back/assets/js/pages/pages/index.js') }}?v=2"></script>
@endpush
