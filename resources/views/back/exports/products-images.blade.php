<table>
    <thead>
        <tr>
            <th>ردیف</th>
            <th>آیدی محصول</th>
            <th>آیدی تصویر</th>
            <th>آدرس تصویر</th>
        </tr>
    </thead>
    <tbody>
        @php
            $count = 1;
        @endphp

        @foreach($products as $product)

            @foreach ($product->gallery()->orderBy('ordering')->get() as $image)
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $product->id }}</td>
                    <td>{{ $image->id }}</td>
                    <td>{{ $image->image }}</td>
                </tr>
            @endforeach

        @endforeach
    </tbody>
</table>
