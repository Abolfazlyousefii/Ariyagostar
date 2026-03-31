<div class="table-responsive">
    <table class="table">
        <tbody>
            <tr>
                <th scope="row" style="min-width: 200px;">{{ trans('front::messages.wallet.id') }}</th>
                <td>{{ $history->id }}</td>
            </tr>

            <tr>
                <th scope="row">{{ trans('front::messages.wallet.amount') }}</th>
                <td>{{ trans('front::messages.currency.prefix') }}{{ number_format($history->amount) }}{{ trans('front::messages.currency.suffix') }}</td>
            </tr>
            <tr>
                <th scope="row">{{ trans('front::messages.wallet.type-of-transaction') }}</th>
                <td>
                    @if ($history->type == 'deposit')
                    {{ trans('front::messages.wallet.increase-credit') }}
                        <div class="badge badge-success ml-1">
                            <i class="mdi mdi-arrow-up"></i>
                        </div>
                    @else
                    {{ trans('front::messages.wallet.decrease-credit') }}
                        <div class="badge badge-danger ml-1">
                            <i class="mdi mdi-arrow-down"></i>
                        </div>
                    @endif
                </td>
            </tr>

            <tr>
                <th scope="row">{{ trans('front::messages.wallet.transaction-date') }}</th>
                <td class="ltr">{{ jdate($history->created_at) }}</td>
            </tr>
            <tr>
                <th scope="row">{{ trans('front::messages.wallet.state') }}</th>
                <td>
                    @if($history->status == 'success')
                        <div class="badge badge-pill badge-success badge-md">{{ trans('front::messages.wallet.successful') }}</div>
                    @else
                        <div class="badge badge-pill badge-danger badge-md">{{ trans('front::messages.wallet.unsuccessful') }}</div>
                    @endif
                </td>
            </tr>

            <tr>
                <th scope="row">{{ trans('front::messages.wallet.description') }}</th>
                <td>{!! $history->description !!}</td>
            </tr>

            @if ($history->order)
                <tr>
                    <th scope="row">{{ trans('front::messages.wallet.order-number') }}</th>
                    <td><a target="_blank" href="{{ route('front.orders.show', ['order' => $history->order]) }}">{{ $history->order->id }}</a></td>
                </tr>
            @endif

            @if ($history->transaction)
                <tr>
                    <th scope="row">{{ trans('front::messages.wallet.transaction-number') }}</th>
                    <td>{{ $history->transaction->transId }}</td>
                </tr>
                <tr>
                    <th scope="row">{{ trans('front::messages.wallet.issue-tracking') }}</th>
                    <td>{{ $history->transaction->traceNumber }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
