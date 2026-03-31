<table>
    <thead>
        <tr>
            <th>ردیف</th>
            <th>آیدی محصول</th>
            <th>آیدی قیمت</th>
            <th>مشخصات</th>
            <th>قیمت</th>
            <th>تخفیف</th>
            <th>بیشترین تعداد مجاز در سفارش</th>
            <th>کمترین تعداد مجاز در سفارش</th>
            <th>موجودی انبار</th>
            <th>قیمت نهایی</th>
            <th>ارز</th>
        </tr>
    </thead>
    <tbody>
        @php
            $count = 1;
        @endphp

        @foreach($products as $product)

            @foreach ($product->prices as $price)
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $product->id }}</td>
                    <td>{{ $price->id }}</td>
                    <td>{{ $price->getAttributesName() }}</td>
                    <td>{{ $price->price }}</td>
                    <td>{{ $price->discount }}</td>
                    <td>{{ $price->cart_max }}</td>
                    <td>{{ $price->cart_min }}</td>
                    <td>{{ $price->stock }}</td>
                    <td>{{ $price->tomanPrice() }}</td>
                    <td>{{ $price->product->currency->title ?? 'تومان' }}</td>
                </tr>
            @endforeach

        @endforeach
    </tbody>
</table>
