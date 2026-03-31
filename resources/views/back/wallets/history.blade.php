<div class="table-responsive">
    <table class="table">
        <tbody>
            <tr>
                <th scope="row" style="min-width: 200px;">آیدی</th>
                <td>{{ $history->id }}</td>
            </tr>

            <tr>
                <th scope="row">مبلغ</th>
                <td>{{ number_format($history->amount) }} تومان</td>
            </tr>
            <tr>
                <th scope="row">نوع تراکنش</th>
                <td>
                    @if ($history->type == 'deposit')
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
                <td>{{ jdate($history->created_at) }}</td>
            </tr>
            <tr>
                <th scope="row">وضعیت</th>
                <td>
                    @if($history->status == 'success')
                        <div class="badge badge-pill badge-success badge-md">موفق</div>
                    @else
                        <div class="badge badge-pill badge-danger badge-md">ناموفق</div>
                    @endif
                </td>
            </tr>

            <tr>
                <th scope="row">توضیحات</th>
                <td>{!! $history->description !!}</td>
            </tr>

            @if ($history->transaction)
                <tr>
                    <th scope="row">شماره تراکنش</th>
                    <td>{{ $history->transaction->transId }}</td>
                </tr>
                <tr>
                    <th scope="row">شماره پیگیری</th>
                    <td>{{ $history->transaction->traceNumber }}</td>
                </tr>
            @endif

            @if ($history->order)
                <tr>
                    <th scope="row">شماره سفارش</th>
                    <td>
                        {{ $history->order->id }}<a class="float-right" href="{{ route('admin.orders.show', ['order' => $history->order]) }}" target="_blank"><i class="feather icon-external-link"></i></a>
                    </td>
                </tr>
            @endif

        </tbody>
    </table>
</div>
