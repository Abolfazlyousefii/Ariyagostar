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
                                    <li class="breadcrumb-item">مدیریت وبلاگ
                                    </li>
                                    <li class="breadcrumb-item active">لیست نوشته ها
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                <div class="card">
                    <div class="card-header filter-card">
                        <h4 class="card-title">فیلتر کردن</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse {{ request()->except('page') ? 'show' : '' }}">
                        <div class="card-body">
                            <div class="users-list-filter">
                                <form id="filter-posts-form" method="GET" action="">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>عنوان</label>
                                            <fieldset class="form-group">
                                                <input class="form-control datatable-filter" name="title" value="{{ request('title') }}">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-3">
                                            <label>وضعیت انتشار</label>
                                            <fieldset class="form-group">
                                                <select class="form-control datatable-filter" name="published">
                                                    <option value="all" {{ request('published') == 'all' ? 'selected' : '' }}>
                                                        همه
                                                    </option>
                                                    <option value="yes" {{ request('published') == 'yes' ? 'selected' : '' }}>
                                                        منتشر شده
                                                    </option>
                                                    <option value="no" {{ request('published') == 'no' ? 'selected' : '' }}>
                                                        پیش نویس
                                                    </option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-3">
                                            <label>مرتب سازی</label>
                                            <fieldset class="form-group">
                                                <select class="form-control datatable-filter" name="sort">
                                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                                        جدیدترین
                                                    </option>
                                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                                        قدیمی ترین
                                                    </option>
                                                    <option value="view" {{ request('sort') == 'view' ? 'selected' : '' }}>
                                                        بازدید
                                                    </option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>دسته بندی ها</label>
                                                <select class="form-control datatable-filter post-category" name="category_id[]" multiple>
                                                    <option class="l1 " data-pup="" {{ request()->input('category_id') && in_array('no_category', request()->input('category_id')) ? 'selected' : '' }} value="no_category">بدون دسته بندی</option>
                                                    @foreach ($categories as $category)
                                                        <option class="l{{ $category->parents()->count() + 1 }} {{ $category->categories()->count() ? 'non-leaf' : '' }}" data-pup="{{ $category->category_id }}" {{ request()->input('category_id') && in_array($category->id, request()->input('category_id')) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-success">فیلتر کردن</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($posts->count())
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست نوشته ها</h4>
                        </div>
                        <div class="card-content" id="main-card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">تصویر شاخص</th>
                                                <th>عنوان</th>
                                                <th class="text-center">تعداد بازدید</th>
                                                <th class="text-center">وضعیت</th>
                                                <th class="text-center">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($posts as $post)
                                                <tr id="post-{{ $post->id }}-tr">
                                                    <td class="text-center">
                                                        <img class="post-thumb" src="{{ $post->image ? asset($post->image) : asset('/empty.jpg') }}" alt="image">
                                                    </td>
                                                    <td><span class="d-inline-block">{{ $post->title }}</span> <a href="{{ Route::has('front.posts.show') ? route('front.posts.show', ['post' => $post]) : '' }}" target="_blank"><i class="feather icon-external-link"></i></a></td>
                                                    <td>{{ number_format($post->view) }}</td>
                                                    <td class="text-center">
                                                        @if ($post->published)
                                                            <div class="badge badge-pill badge-success badge-md">منتشر شده</div>
                                                        @else
                                                            <div class="badge badge-pill badge-danger badge-md">پیش نویس</div>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">

                                                        @can('posts.update')
                                                            <a href="{{ route('admin.posts.edit', ['post' => $post]) }}" class="btn btn-success mr-1 waves-effect waves-light">ویرایش</a>
                                                        @endcan

                                                        @can('posts.delete')
                                                            <button type="button" data-post="{{ $post->slug }}" data-id="{{ $post->id }}" class="btn btn-danger mr-1 waves-effect waves-light btn-delete" data-toggle="modal" data-target="#delete-modal">حذف</button>
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
                            <h4 class="card-title">لیست نوشته ها</h4>
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
                {{ $posts->links() }}

            </div>
        </div>
    </div>

    {{-- delete post modal --}}
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
                    با حذف نوشته دیگر قادر به بازیابی آن نخواهید بود
                </div>
                <div class="modal-footer">
                    <form action="#" id="post-delete-form">
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
    <script src="{{ asset('back/assets/js/pages/posts/index.js') }}"></script>
    <script>
        $('.post-category').select2ToTree({
            rtl: true,
            width: '100%',
            placeholder: 'انتخاب کنید'
        });
    </script>
@endpush
