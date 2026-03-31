<div class="table-responsive">
    <table class="table">
        <tbody>
            <tr>
                <th scope="row" style="min-width: 200px;">آیدی</th>
                <td>{{ $transaction->id }}</td>

            </tr>

            <tr>
                <th scope="row">نوع تراکنش</th>
                <td>
                    {{ $transaction->type() }} <a class="float-right" href="{{ $transaction->link() }}" target="_blank"><i class="feather icon-external-link"></i></a>
                </td>

            </tr>

            @if($transaction->user)
                <tr>
                    <th scope="row">کاربر پرداخت کننده</th>
                    <td>
                        {{ $transaction->user->fullname }} <a class="float-right" href="{{ route('admin.users.show', ['user' => $transaction->user]) }}" target="_blank"><i class="feather icon-external-link"></i></a>
                    </td>
                </tr>
            @endif

            <tr>
                <th scope="row">تاریخ تراکنش</th>
                <td>{{ jdate($transaction->created_at) }}</td>
            </tr>
            <tr>
                <th scope="row">مبلغ</th>
                <td>{{ number_format($transaction->amount) }} تومان</td>

            </tr>
            <tr>
                <th scope="row">وضعیت</th>
                <td>
                    @if($transaction->status)
                        <div class="badge badge-pill badge-success badge-md">موفق</div>
                    @else
                        <div class="badge badge-pill badge-danger badge-md">ناموفق</div>
                    @endif
                </td>
            </tr>

            <tr>
                <th scope="row">شماره تراکنش</th>
                <td>{{ $transaction->transId }}</td>
            </tr>
            <tr>
                <th scope="row">شماره پیگیری</th>
                <td>{{ $transaction->traceNumber ?: '-' }}</td>
            </tr>

            <tr>
                <th scope="row">توضیحات</th>
                <td>{!! $transaction->message ?: '--' !!}</td>
            </tr>
        </tbody>
    </table>
</div>
