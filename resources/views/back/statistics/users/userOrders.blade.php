@extends('back.layouts.master')

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="content-body">
                <form id="filter-products-form" method="GET" action="">
                    <div class="card mb-1">
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

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>گزارش بر اساس</label>
                                            <fieldset class="form-group">
                                                <select class="form-control" name="report_type">
                                                    <option value="price" {{ request('report_type') == 'price' ? 'selected' : '' }}>
                                                        مبلغ سفارشات
                                                    </option>
                                                    <option value="quantity" {{ request('report_type') == 'quantity' ? 'selected' : '' }}>
                                                        تعداد سفارشات
                                                    </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-success">فیلتر کردن</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">سفارشات کاربران</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">



                            @if ($orders->count())
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>ردیف</th>
                                                <th>کاربر</th>
                                                <th>جمع سفارشات</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="d-flex">
                                                        {{ $order->user->fullname }} <a href="{{ route('admin.users.show', ['user' => $order->user]) }}" target="_blank"><i class="feather icon-external-link pl-1"></i></a>
                                                    </td>
                                                    <td>{{ number_format($order->total_sale) }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p>چیزی برای نمایش وجود ندارد!</p>
                            @endif

                        </div>
                    </div>
                </section>

                {{ $orders->links() }}

            </div>
        </div>
    </div>

@endsection
