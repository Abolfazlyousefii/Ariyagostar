@extends('front::user.layouts.master')

@section('user-content')
    <!-- Start Content -->
    <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">

        @if($orders->count())

            <div class="row">
                <div class="col-12">
                    <div
                            class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                        <h2>{{ trans('front::messages.profile.all-orders') }}</h2>
                    </div>
                    <div class="dt-sl">
                        <div class="table-responsive">
                            <table class="table table-order">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('front::messages.profile.order-number') }}</th>
                                    <th>{{ trans('front::messages.profile.order-registration-date') }}</th>
                                    <th>{{ trans('front::messages.profile.total-amount') }}</th>
                                    <th>{{ trans('front::messages.profile.payment-status') }}</th>
                                    <th>{{ trans('front::messages.profile.details') }}</th>

                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td class="text-info">{{ $order->id }}</td>
                                            <td>{{ jdate($order->created_at)->format('%d %B %Y') }}</td>
                                            <td>{{ trans('front::messages.currency.prefix') }}{{ number_format($order->price) }} {{ trans('front::messages.currency.suffix') }}</td>
                                            <td>
                                                @if($order->status == 'paid')
                                                    <span class="text-success">{{ trans('front::messages.profile.paid') }}</span> @if ($order->reserved())(رزرو شده) @endif
                                                @elseif($order->status == 'unpaid')
                                                    <span class="text-danger">{{ trans('front::messages.profile.unpaid') }}</span>
                                                @else
                                                    <span class="text-danger">{{ trans('front::messages.profile.canceled') }}</span>
                                                @endif
                                            </td>
                                            <td class="details-link">
                                                <a href="{{ route('front.orders.show', ['order' => $order]) }}">
                                                    <i class="mdi mdi-chevron-left"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <div class="row">
                <div class="col-12">
                    <div class="page dt-sl dt-sn pt-3">
                        <p>{{ trans('front::messages.profile.there-nothing-show') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-3">
            {{ $orders->links('front::components.paginate') }}
        </div>

    </div>
    <!-- End Content -->
@endsection
