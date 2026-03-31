@php
    $filters = $request->filters;
@endphp

<table>
    <thead>
        <tr>
            @isset($filters['row'])
                <th>ردیف</th>
            @endisset

            @isset($filters['id'])
                <th>آیدی</th>
            @endisset

            @isset($filters['title'])
                <th>عنوان</th>
            @endisset

            @isset($filters['title_en'])
                <th>عنوان انگلیسی</th>
            @endisset

            @isset($filters['category'])
                <th>نام دسته بندی</th>
            @endisset

            @isset($filters['type'])
                <th>نوع محصول</th>
            @endisset

            @isset($filters['brand'])
                <th>برند</th>
            @endisset

            @isset($filters['weight'])
                <th>وزن</th>
            @endisset

            @isset($filters['unit'])
                <th>واحد</th>
            @endisset

            @isset($filters['labels'])
                <th>برچسب</th>
            @endisset

            @isset($filters['short_description'])
                <th>توضیحات کوتاه</th>
            @endisset

            @isset($filters['description'])
                <th>توضیحات</th>
            @endisset

            @isset($filters['publish_date'])
                <th>تاریخ انتشار</th>
            @endisset

            @isset($filters['special'])
                <th>محصول ویژه</th>
            @endisset

            @isset($filters['published'])
                <th>پیش نویس</th>
            @endisset

            @isset($filters['image'])
                <th>تصویر شاخص</th>
            @endisset

            @isset($filters['meta_title'])
                <th>عنوان سئو</th>
            @endisset

            @isset($filters['slug'])
                <th>slug</th>
            @endisset

            @isset($filters['tags'])
                <th>کلمات کلیدی</th>
            @endisset

        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                @isset($filters['row'])
                    <td>{{ $loop->iteration }}</td>
                @endisset

                @isset($filters['id'])
                    <td>{{ $product->id }}</td>
                @endisset

                @isset($filters['title'])
                    <td>{{ $product->title }}</td>
                @endisset

                @isset($filters['title_en'])
                    <td>{{ $product->title_en }}</td>
                @endisset

                @isset($filters['category'])
                    <td>{{ $product->category->title ?? '' }}</td>
                @endisset

                @isset($filters['type'])
                    <td>{{ $product->isPhysical() ? 'فیزیکی' : 'دانلودی' }}</td>
                @endisset

                @isset($filters['brand'])
                    <td>{{ $product->brand->name ?? '' }}</td>
                @endisset

                @isset($filters['weight'])
                    <td>{{ $product->weight }}</td>
                @endisset

                @isset($filters['unit'])
                    <td>{{ $product->unit }}</td>
                @endisset

                @isset($filters['labels'])
                    <td>{{ $product->getLabels() }}</td>
                @endisset

                @isset($filters['short_description'])
                    <td>{{ $product->short_description }}</td>
                @endisset

                @isset($filters['description'])
                    <td>{{ $product->description }}</td>
                @endisset

                @isset($filters['publish_date'])
                    <td>{{ $product->publish_date }}</td>
                @endisset

                @isset($filters['special'])
                    <td>{{ $product->isSpecial() }}</td>
                @endisset

                @isset($filters['published'])
                    <td>{{ $product->published }}</td>
                @endisset

                @isset($filters['image'])
                    <td>{{ $product->image }}</td>
                @endisset

                @isset($filters['meta_title'])
                    <td>{{ $product->meta_title }}</td>
                @endisset

                @isset($filters['slug'])
                    <td>{{ $product->slug }}</td>
                @endisset

                @isset($filters['tags'])
                    <td>{{ $product->getTags }}</td>
                @endisset
            </tr>
        @endforeach
    </tbody>
</table>
