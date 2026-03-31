@extends('back.layouts.master')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('back/assets/css/pages/users/show.css') }}">
@endpush


@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">مشخصات کاربر</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">مدیریت
                                    </li>
                                    <li class="breadcrumb-item">مدیریت کاربران
                                    </li>
                                    <li class="breadcrumb-item active">مشخصات کاربر
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card user-statistics-card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 title="{{ convert_number($user->getWallet()->balance()) }}" class="text-bold-700 mb-0">{{ number_format($user->getWallet()->balance()) }}</h2>
                                    <p>موجودی کیف پول</p>
                                </div>
                                <div class="avatar bg-rgba-info p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="fa fa-credit-card text-info font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <span>
                                    <a href="{{ route('admin.wallets.show', ['wallet' => $user->getWallet()]) }}" class="card-link">تاریخچه کیف پول <i class="fa fa-angle-left"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card user-statistics-card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0">{{ $user->orders()->count() }}</h2>
                                    <p>تعداد سفارشات</p>
                                </div>
                                <div class="avatar bg-rgba-primary p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-briefcase text-primary font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <span>
                                    <a href="{{ route('admin.orders.index', ['username' => $user->username]) }}" class="card-link">مشاهده همه <i class="fa fa-angle-left"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card user-statistics-card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0">{{ $user->comments()->count() }}</h2>
                                    <p>تعداد نظرات</p>
                                </div>
                                <div class="avatar bg-rgba-success p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-message-circle text-success font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <span>
                                    <a href="#" class="card-link">مشاهده همه <i class="fa fa-angle-left"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card user-statistics-card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 class="text-bold-700 mb-0">{{ $user->cart ? $user->cart->products()->count() : 0 }}</h2>
                                    <p>سبد خرید</p>
                                </div>
                                <div class="avatar bg-rgba-danger p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <span>
                                    <a href="#" class="card-link">مشاهده همه <i class="fa fa-angle-left"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card user-statistics-card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 title="کل بازدید: {{ $user->views()->count() }}" class="text-bold-700 mb-0">{{ $user->views()->whereDate('created_at', now())->count() }}</h2>
                                    <p>بازدید امروز</p>
                                </div>
                                <div class="avatar bg-rgba-warning p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-eye text-warning font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <span>
                                    <a href="{{ route('admin.users.views', ['user' => $user]) }}" class="card-link">مشاهده همه <i class="fa fa-angle-left"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    @php
                        $orders_sum = $user->orders()->paid()->sum('price')
                    @endphp

                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card user-statistics-card">
                            <div class="card-header d-flex align-items-start pb-0">
                                <div>
                                    <h2 title="ارزش سفارشات: {{ number_format($orders_sum) }} تومان" class="text-bold-700 mb-0">{{ formatPriceUnits($orders_sum) }}</h2>
                                    <p>ارزش سفارشات موفق</p>
                                </div>
                                <div class="avatar bg-rgba-primary p-50 m-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-briefcase text-primary font-medium-5"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <span>
                                    <a href="{{ route('admin.orders.index', ['username' => $user->username]) }}" class="card-link">مشاهده همه <i class="fa fa-angle-left"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <section  class="card">
                    <div class="card-header">
                        <h4 class="card-title">مشخصات کاربر</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <section class="page-users-view">
                                <div class="row">
                                    <!-- account start -->
                                    <div class="col-12">
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="users-view-image">
                                                        <img src="{{ $user->imageUrl }}" class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                                                    </div>
                                                    <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                                        <table>
                                                            <tr>
                                                                <td class="font-weight-bold">نام</td>
                                                                <td>{{ $user->first_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="font-weight-bold">نام خانوادگی</td>
                                                                <td>{{ $user->last_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="font-weight-bold">ایمیل</td>
                                                                <td>{{ $user->email ?: '--' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="font-weight-bold">نام کاربری</td>
                                                                <td>{{ $user->username }}</td>
                                                            </tr>
                                                            <tr>
                                                            <tr>
                                                                <td class="font-weight-bold">تاریخ ثبت نام</td>
                                                                <td>
                                                                    <abbr title="{{ jdate($user->created_at) }}">{{ jdate($user->created_at)->ago() }}</abbr>
                                                                </td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-5">
                                                        <table class="ml-0 ml-sm-0 ml-lg-0">
                                                            <tr>
                                                                <td class="font-weight-bold">آیدی</td>
                                                                <td>{{ $user->id }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="font-weight-bold">آدرس</td>
                                                                <td>{{ $user->address ? $user->address->province->name . ' - ' . $user->address->city->name : '--' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="font-weight-bold">کد پستی</td>
                                                                <td>{{ $user->address ? $user->address->postal_code : '--' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="font-weight-bold">آدرس کامل</td>
                                                                <td>{{ $user->address ? $user->address->address : '--' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="font-weight-bold">تاریخ تولد</td>
                                                                <td>
                                                                    {{ $user->birthday ? jdate($user->birthday)->format('Y/m/d') : '' }}
                                                                </td>
                                                            </tr>


                                                        </table>
                                                    </div>
                                                    <div class="col-md-10 offset-md-1 mt-2">
                                                        <a href="{{ route('admin.users.login', ['user' => $user]) }}" class="btn btn-primary mr-1">وارد شدن به عنوان کاربر</a>
                                                        @can('users.update')
                                                            <a href="{{ route('admin.users.edit', ['user' => $user]) }}" class="btn btn-warning mr-1"><i class="feather icon-edit-1"></i> ویرایش</a>
                                                        @endcan

                                                        @can('users.delete')

                                                            @if($user->id != auth()->user()->id)
                                                                <button type="button" data-user="{{ $user->id }}" class="btn btn-danger mr-1 waves-effect waves-light btn-user-delete"  data-toggle="modal" data-target="#user-delete-modal">حذف</button>
                                                            @else
                                                                <button type="button" class="btn btn-danger mr-1 waves-effect waves-light" disabled>حذف</button>
                                                            @endif

                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- account end -->

                                </div>
                            </section>
                            <!-- page users view end -->

                        </div>
                    </div>
                </section>

                <div class="row match-height">

                    @if ($user->orders()->count())
                        <div class="col-md-12">
                            <section class="card">
                                <div class="card-header">
                                    <h4 class="card-title">آخرین سفارشات</h4>
                                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                                            <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>شماره سفارش</th>
                                                        <th>تاریخ</th>
                                                        <th>مبلغ</th>
                                                        <th>وضعیت</th>
                                                        <th class="text-center">عملیات</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($user->orders()->latest()->take(5)->get() as $order)
                                                        <tr>
                                                            <td>{{ $order->id }}</td>
                                                            <td title="{{ jdate($order->created_at) }}">{{ jdate($order->created_at)->ago() }}</td>
                                                            <td title="{{ convert_number($order->price) }} تومان">{{ number_format($order->price) }}</td>
                                                            <td>{{ $order->statusText() }}</td>
                                                            <td class="text-center">
                                                                <a href="{{ route('admin.orders.show', ['order' => $order]) }}" class="btn btn-warning waves-effect waves-light">مشاهده</a>
                                                            </td>

                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </section>
                        </div>
                    @endif

                    <div class="col-md-6">
                        <section class="card">
                            <div class="card-header">
                                <h4 class="card-title">آخرین نظرات</h4>
                            </div>
                            <div class="card-content">
                                @if ($user->comments()->count())
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>دیدگاه</th>
                                                        <th class="text-center">وضعیت</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($user->comments()->latest()->get() as $comment)
                                                        <tr>
                                                            <td style="max-width: 300px">{{ $comment->body }}</td>
                                                            <td class="text-center">
                                                                @if($comment->status == 'pending')
                                                                    <div class="badge badge-pill badge-warning badge-md">منتظر تایید</div>
                                                                @elseif($comment->status == 'accepted')
                                                                    <div class="badge badge-pill badge-success badge-md">تایید شده</div>
                                                                @else
                                                                    <div class="badge badge-pill badge-danger badge-md">تایید نشده</div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer text-muted text-right">
                                        <span>
                                            <a href="#" class="card-link">مشاهده همه <i class="fa fa-angle-left"></i></a>
                                        </span>
                                    </div>
                                @else
                                    <div class="card-body">
                                        <div class="card-text">
                                            <p>چیزی برای نمایش وجود ندارد!</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </section>
                    </div>

                    <div class="col-md-6">
                        <section class="card">
                            <div class="card-header">
                                <h4 class="card-title">سبد خرید</h4>
                            </div>
                            <div class="card-content">
                                @if ($user->cart && $user->cart->products()->count())
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>تصویر</th>
                                                        <th>نام محصول</th>
                                                        <th>تعداد</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($user->cart->products as $product)
                                                        <tr>
                                                            <td>
                                                                <img class="post-thumb" src="{{ $product->imageUrl() }}" alt="image">
                                                            </td>
                                                            <td >{{ $product->title }}
                                                                <a href="{{ Route::has('front.products.show') ? route('front.products.show', ['product' => $product]) : '' }}" target="_blank">
                                                                    <i class="feather icon-external-link"></i>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                {{ $product->pivot->quantity }}
                                                            </td>

                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                @else
                                    <div class="card-body">
                                        <div class="card-text">
                                            <p>چیزی برای نمایش وجود ندارد!</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </section>
                    </div>

                    <div class="col-md-12">
                        <section class="card">
                            <div class="card-header">
                                <h4 class="card-title">آخرین بازدیدها</h4>
                            </div>
                            <div class="card-content">
                                @if ($user->views()->count())
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="min-width: 200px;">تاریخ</th>
                                                        <th>ip</th>
                                                        <th>platform</th>
                                                        <th class="text-center">آدرس</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($user->views()->latest()->take(10)->get() as $view)
                                                        <tr>
                                                            <td class="ltr">{{ jdate($view->created_at) }}</td>
                                                            <td>{{ $view->ip }}</td>
                                                            <td>{{ get_option_property($view->options, 'platform') }}</td>
                                                            <td class="ltr text-right"><a class="text-dark" target="_blank" href="{{ url(urldecode($view->path)) }}">{{ urldecode($view->path) }}</a></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer text-muted text-right">
                                        <span>
                                            <a href="{{ route('admin.users.views', ['user' => $user]) }}" class="card-link">مشاهده همه <i class="fa fa-angle-left"></i></a>
                                        </span>
                                    </div>
                                @else
                                    <div class="card-body">
                                        <div class="card-text">
                                            <p>چیزی برای نمایش وجود ندارد!</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </section>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- delete user modal --}}
    <div class="modal fade text-left" id="user-delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel19" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    با حذف کاربر دیگر قادر به بازیابی آن نخواهید بود
                </div>
                <div class="modal-footer">
                    <form action="#" id="user-delete-form">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">خیر</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">بله حذف شود</button>
                    </form>
                </div>
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
                    با حذف درخواست  دیگر قادر به بازیابی آن نخواهید بود
                </div>
                <div class="modal-footer">
                    <form action="#" id="agency-delete-form">
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
    <script src="{{ asset('back/assets/js/pages/users/show.js') }}"></script>
@endpush
