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
                                    <li class="breadcrumb-item active">لیست تخفیف ها
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
                                <form method="GET">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <label>کد تخفیف</label>
                                            <fieldset class="form-group">
                                                <input class="form-control" name="code" value="{{ request('code') }}">
                                            </fieldset>
                                        </div>

                                        <div class="col-md-4">
                                            <label>کاربر</label>
                                            <fieldset class="form-group">
                                                <select name="user_id" class="form-control select2">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}" {{ request()->user_id == $user->id ? "selected" : ""}}>{{ $user->fullName }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-12">
                                            <button class="btn btn-success">ثبت</button>

                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                @if ($discounts->count())
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست تخفیف ها</h4>
                        </div>
                        <div class="card-content" id="main-card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>عنوان</th>
                                                <th>کد تخفیف</th>
                                                <th>تاریخ ایجاد</th>
                                                <th>تعداد سفارش موفق</th>
                                                <th class="text-center">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($discounts as $discount)
                                                <tr id="discount-{{ $discount->id }}-tr">
                                                    <td class="text-center">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>{{ $discount->title }}</td>
                                                    <td>{{ $discount->code ?? 'اعمال مستقیم روی محصولات' }}</td>
                                                    <td>{{ jdate($discount->created_at)->format('%d %B %Y') }}</td>
                                                    <td>{{ $discount->orders()->paid()->count() }}</td>

                                                    <td class="text-center">
                                                        <a class="btn btn-warning waves-effect waves-light"
                                                            href="{{ route('admin.discounts.edit', ['discount' => $discount]) }}">ویرایش</a>
                                                        <button data-discount="{{ $discount->id }}"
                                                            data-action="{{ route('admin.discounts.destroy', ['discount' => $discount]) }}"
                                                            type="button"
                                                            class="btn btn-danger waves-effect waves-light btn-delete"
                                                            data-toggle="modal" data-target="#delete-modal">حذف</button>
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
                            <h4 class="card-title">لیست تخفیف ها</h4>
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
                {{ $discounts->links() }}


            </div>
        </div>
    </div>

    {{-- delete post modal --}}
    <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    با حذف کد تخفیف دیگر قادر به بازیابی آن نخواهید بود
                </div>
                <div class="modal-footer">
                    <form action="#" id="discount-delete-form">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-success waves-effect waves-light"
                            data-dismiss="modal">خیر</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">بله حذف شود</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/discounts/index.js') }}"></script>
@endpush
