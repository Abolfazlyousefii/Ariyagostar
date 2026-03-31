@extends('front::user.layouts.master')

@section('user-content')
    <!-- Start Content -->
    <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">

        @if ($refrrals->count())
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                        <h2>لیست کد های تخفیف که توسط معرفی افراد برای شما ثبت شده اند</h2>
                    </div>
                    <div class="dt-sl">
                        <div class="table-responsive">
                            <table class="table table-order">
                                <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>کد تخفیف</th>
                                        <th>نام و نام خانوادگی</th>
                                        <th>شماره تلفن</th>
                                        <th>تاریخ ثبت نام</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($refrrals as $refrral)
                                        <tr>
                                            <td class="text-info">{{ $loop->iteration }}</td>
                                            @if ($refrral->user_id == auth()->id())
                                                <td>{{ $refrral->userDiscount->code . '   ' . '(' . number_format($refrral->userDiscount->amount) . '%)' }}</td>
                                            @else
                                                <td>{{ $refrral->referralDiscount->code . '   ' . '(' . number_format($refrral->referralDiscount->amount) . '%)' }}</td>
                                            @endif
                                            <td>{{ $refrral->user->fullname }}</td>
                                            <td>{{ $refrral->user->username }}</td>
                                            <td>{{ jdate($refrral->user->created_at)->format('%d %B %Y') }}</td>
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
            {{ $refrrals->links('front::components.paginate') }}
        </div>

    </div>
    <!-- End Content -->
@endsection
