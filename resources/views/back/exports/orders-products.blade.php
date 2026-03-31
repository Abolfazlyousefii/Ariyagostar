<table>
    <thead>
        <tr>
            <th>ردیف</th>
            <th>آیدی سفارش</th>
            <th>آیدی محصول</th>
            <th>نام محصول</th>
            <th>تعداد</th>
            <th>قیمت واحد</th>
            <th>قیمت کل</th>
            <th>تخفیف</th>
            <th>قیمت نهایی</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)

            @foreach($order->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->order_id }}</td>
                    <td>{{ $item->product_id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->realPrice() }}</td>
                    <td>{{ $item->quantity * $item->realPrice() }}</td>
                    <td>{{ $item->discount }}</td>
                    <td>{{ $item->price * $item->quantity }}</td>
                </tr>
            @endforeach

        @endforeach
    </tbody>
</table>
