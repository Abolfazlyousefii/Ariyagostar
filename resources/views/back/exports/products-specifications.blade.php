<table>
    <thead>
        <tr>
            <th>ردیف</th>
            <th>آیدی محصول</th>
            <th>عنوان گروه</th>
            <th>عنوان مشخصه</th>
            <th>مقدار</th>
        </tr>
    </thead>
    <tbody>
        @php
            $count = 1;
        @endphp

        @foreach($products as $product)

            @foreach ($product->specificationGroups->unique() as $group)

                @foreach($product->specifications()->where('specification_group_id', $group->id)->get() as $specification)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $product->id }}</td>
                        <td>{{ $group->name }}</td>
                        <td>{{ $specification->name }}</td>
                        <td>{{ $specification->pivot->value }}</td>
                    </tr>
                @endforeach

            @endforeach

        @endforeach
    </tbody>
</table>
