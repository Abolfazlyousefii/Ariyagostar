<div class="table-responsive">
    <table class="table">
        <tbody>
            <tr>
                <th scope="row" style="min-width: 200px;">آیدی</th>
                <td>{{ $wallet_history->id }}</td>
            </tr>
            <tr>
                <th scope="row">کاربر مربوطه</th>
                <td>
                    {{ $wallet_history->wallet->user->fullname }}<a class="float-right" href="{{ route('admin.users.show', ['user' => $wallet_history->wallet->user]) }}" target="_blank"><i class="feather icon-external-link"></i></a>
                </td>
            </tr>

            <tr>
                <th scope="row">مبلغ</th>
                <td>{{ number_format($wallet_history->amount) }} تومان</td>
            </tr>
            <tr>
                <th scope="row">نوع تراکنش</th>
                <td>
                    @if ($wallet_history->type == 'deposit')
                        افزایش اعتبار
                        <div class="badge badge-success ml-1">
                            <i class="feather icon-arrow-up"></i>
                        </div>
                    @else
                        کاهش اعتبار
                        <div class="badge badge-danger ml-1">
                            <i class="feather icon-arrow-down"></i>
                        </div>
                    @endif
                </td>
            </tr>

            <tr>
                <th scope="row">تاریخ تراکنش</th>
                <td>{{ jdate($wallet_history->created_at) }}</td>
            </tr>
            <tr>
                <th scope="row">وضعیت</th>
                <td>
                    @if($wallet_history->status == 'success')
                        <div class="badge badge-pill badge-success badge-md">موفق</div>
                    @else
                        <div class="badge badge-pill badge-danger badge-md">ناموفق</div>
                    @endif
                </td>
            </tr>

            <tr>
                <th scope="row">توضیحات</th>
                <td>{!! $wallet_history->description !!}</td>
            </tr>

            @if ($wallet_history->transaction)
                <tr>
                    <th scope="row">شماره تراکنش</th>
                    <td>{{ $wallet_history->transaction->transId }}</td>
                </tr>
                <tr>
                    <th scope="row">شماره پیگیری</th>
                    <td>{{ $wallet_history->transaction->traceNumber }}</td>
                </tr>
            @endif

            @if ($wallet_history->order)
                <tr>
                    <th scope="row">شماره سفارش</th>
                    <td>
                        {{ $wallet_history->order->id }}<a class="float-right" href="{{ route('admin.orders.show', ['order' => $wallet_history->order]) }}" target="_blank"><i class="feather icon-external-link"></i></a>
                    </td>
                </tr>
            @endif

        </tbody>
    </table>
</div>
