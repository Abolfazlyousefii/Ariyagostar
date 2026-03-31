@extends('front::user.layouts.master')

@section('user-content')
    <!-- Start Content -->
    <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">
        <div class="row">
            <div class="col-lg-6">
                <div class="px-3">
                    <div class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2">
                        <h2>{{ trans('front::messages.profile.personal-information') }}</h2>
                    </div>
                    <div class="profile-section dt-sl">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="label-info">
                                    <span>{{ trans('front::messages.profile.fname') }}</span>
                                </div>
                                <div class="value-info">
                                    <span>{{ $user->first_name }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="label-info">
                                    <span>{{ trans('front::messages.profile.lname') }}</span>
                                </div>
                                <div class="value-info">
                                    <span>{{ $user->last_name }}</span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="label-info">
                                    <span>{{ trans('front::messages.profile.phone-number') }}</span>
                                </div>
                                <div class="value-info">
                                    <span>{{ $user->username }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="label-info">
                                    <span>{{ trans('front::messages.profile.email') }}</span>
                                </div>
                                <div class="value-info">
                                    <span>{{ $user->email ?: '-' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="label-info">
                                    <span>{{ trans('front::messages.profile.state') }}</span>
                                </div>
                                <div class="value-info">
                                    <span>{{ $user->address ? $user->address->province->name : '-' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="label-info">
                                    <span>{{ trans('front::messages.profile.city') }}</span>
                                </div>
                                <div class="value-info">
                                    <span>{{ $user->address ? $user->address->city->name : '-' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="label-info">
                                    <span>{{ trans('front::messages.profile.postal-code') }}</span>
                                </div>
                                <div class="value-info">
                                    <span>{{ $user->address ? $user->address->postal_code : '-' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="label-info">
                                    <span>{{ trans('front::messages.profile.complete-address') }}</span>
                                </div>
                                <div class="value-info address">
                                    <span title="{{ $user->address ? $user->address->address : '-' }}">{{ $user->address ? ellips_text($user->address->address, 80) : '-' }}</span>
                                </div>
                            </div>

                        </div>
                        <div class="profile-section-link">
                            <a href="{{ route('front.user.profile.edit') }}" class="border-bottom-dt">
                                <i class="mdi mdi-account-edit-outline"></i>
                                {{ trans('front::messages.profile.edit-personal-information') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-12">
                <div class="px-3">
                    <div
                        class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2">
                        <h2>{{ trans('front::messages.profile.list-latest-favorites') }}</h2>
                    </div>
                    <div class="profile-section dt-sl">
                        @if ($user->favorites()->count())
                            <ul class="list-favorites">
                                @foreach ($user->favorites()->latest()->take(3)->get() as $favorite)
                                    <li>
                                        <a href="{{ route('front.products.show', ['product' => $favorite->product]) }}">
                                            <img data-src="{{  $favorite->product->image ? asset($favorite->product->image) : asset('/no-image-product.png') }}" alt="">
                                            <span>{{ $favorite->product->title }}</span>
                                        </a>
                                        <button data-action="{{ route('front.favorites.destroy', ['favorite' => $favorite]) }}" data-toggle="modal" data-target="#favorite-delete-modal" class="favorite-remove-btn">
                                            <i class="mdi mdi-trash-can-outline"></i>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="profile-section-link">
                                <a href="{{ route('front.favorites.index') }}" class="border-bottom-dt">
                                    <i class="mdi mdi-square-edit-outline"></i>
                                    {{ trans('front::messages.profile.view-favorites') }}
                                </a>
                            </div>
                        @else
                            <p class="mt-2">{{ trans('front::messages.profile.there-nothing-show') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            @if($last_orders->count())
                <div class="col-lg-12 mt-3">
                    <div class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                        <h2>{{ trans('front::messages.profile.latest-orders') }}</h2>
                    </div>
                    <div class="dt-sl">
                        <div class="table-responsive">
                            <table class="table table-order">
                                <thead>
                                <tr>
                                    <td>#</td>
                                    <th>{{ trans('front::messages.profile.order-number')}}</th>
                                    <th>{{ trans('front::messages.profile.order-registration-date')}}</th>
                                    <th>{{ trans('front::messages.profile.payment-status')}}</th>
                                    <th>{{ trans('front::messages.profile.details')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($last_orders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td class="text-info">{{ $order->id }}</td>
                                            <td>{{ jdate($order->created_at)->format('%d %B %Y') }}</td>
                                            <td>
                                                @if($order->status == 'paid')
                                                    <span class="text-success">{{ trans('front::messages.profile.paid')}}</span>
                                                @elseif($order->status == 'unpaid')
                                                    <span class="text-danger">{{ trans('front::messages.profile.unpaid')}}</span>
                                                @else
                                                    <span class="text-danger">{{ trans('front::messages.profile.canceled')}}</span>
                                                @endif
                                            </td>
                                            <td class="details-link">
                                                <a href="{{ route('front.orders.show', ['order' => $order]) }}">
                                                    <i class="mdi mdi-chevron-left"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                <tr>
                                    <td class="link-to-orders" colspan="7"><a href="{{ route('front.orders.index') }}">{{ trans('front::messages.profile.view-list-orders')}}</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>

    </div>
    <!-- End Content -->
@endsection

@push('scripts')
    <!-- Start favorite delete -->
    <div class="modal fade" id="favorite-delete-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="now-ui-icons location_pin"></i>
                        {{ trans('front::messages.profile.remove-from-favorites')}}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <p> {{ trans('front::messages.profile.remove-this-product')}}</p>

                            <div class="form-ui dt-sl">
                                <form id="favorite-remove-form" action="#" method="POST">
                                    <div class="modal-body text-center">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-md"> {{ trans('front::messages.profile.yes-delete')}}</button>
                                        <button class="btn btn-light" data-dismiss="modal">{{ trans('front::messages.profile.cancellation')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End favorite delete -->

    <script src="{{ theme_asset('js/pages/favorites/index.js') }}"></script>
@endpush
