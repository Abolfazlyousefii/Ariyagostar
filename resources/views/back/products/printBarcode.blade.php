@php
    $pageWidth = $request->input('filters.pageWidth');
    $pageHeight = $request->input('filters.pageHeight');
    $store_title_font = $request->input('filters.store_title_font');
    $title_font = $request->input('filters.title_font');
    $price_font = $request->input('filters.price_font');
    $discount_price_font = $request->input('filters.discount_price_font');
    $columnCount = $request->input('filters.columnCount');
    $counter = 0;
@endphp
<!DOCTYPE html>
<html lang="fa">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>چاپ بارکد</title>

        <link rel="stylesheet" href="{{ asset('back/assets/fonts/vazir/style.css') }}">
        <style>
            @page {
                size: {{ $pageWidth }}mm {{ $pageHeight }}mm;
                /* تنظیم اندازه صفحه برای چاپگر */
                margin: 0;
            }

            @media print {
                .label-item {
                    height: 100vh;
                    overflow: hidden;
                }
            }

            html,
            body {
                width: {{ $pageWidth }}mm;
                /* عرض صفحه */
                height: {{ $pageHeight }}mm;
                /* ارتفاع صفحه */
            }

            body {

                margin: 0;
                padding: 0;
                direction: rtl;

            }

            .label-container {
                display: flex;
                flex-wrap: wrap;
                padding: 0;
                box-sizing: border-box;
                width: 100%;

            }

            .label-item {
                box-sizing: border-box;
                width: {{ 100 / $columnCount }}%;
                height: {{ $pageHeight }}mm;
                padding: 2mm;
                text-align: center;
                /* border: 1px dashed #000; */
                margin-bottom: 0mm;
                align-items: center;
                display: flex;
                flex-direction: column;
                justify-content: center;
                page-break-after: always;
            }

            .site-title {
                font-size: {{ $store_title_font }}em;
                font-weight: 700;
                margin-bottom: .5mm;
            }

            .product-name {
                font-size: {{ $title_font }}em;
                font-weight: 600;
                margin-bottom: 0.4mm;
            }

            .product-price {
                font-size: {{ $price_font }}em;
                margin-top: 0mm;
                font-weight: 900;
            }

            .product-price del {
                font-size: {{ $discount_price_font }}em;
            }

            .product-code {
                margin-top: 0mm;
            }

            .page-break {
                page-break-after: always
            }
        </style>
    </head>

    <body>
        <div class="label-container">

            @foreach ($prices as $price)
                @for ($i = 0; $i < $request->prices[$price->id]['count']; $i++)
                    <div class="label-item">
                        @if ($request->has('filters.store_title'))
                            <div class="site-title">{{ option('info_site_title') }}</div>
                        @endif
                        <div class="product-name">
                            @if ($request->has('filters.title'))
                                {{ $price->product->title }}
                            @endif
                            @if ($request->has('filters.price_attributes'))
                                {{ $price->getAttributesValue() }}
                            @endif
                        </div>
                        @if ($request->has('filters.barcode'))
                            <div class="product-code"><img style="height: 3mm;max-width: 90%; object-fit: contain; margin: 0" src="{{ barcode('p-' . $price->id) }}" alt="barcode"></div>
                        @endif
                        @if ($request->has('filters.price'))
                            <div class="product-price" style="display: flex; align-items: end;margin: 0px 3px;">قيمت:
                                <div style="display: inline-flex; flex-direction: column;">
                                    @if ($request->has('filters.discount_price') && $price->hasDiscount())
                                        <del>{{ number_format($price->regularPrice()) }}</del>
                                    @endif
                                    <span style="margin: 0 2px;">{{ number_format($price->salePrice()) }}</span>
                                </div> تومان
                            </div>
                        @endif
                    </div>

                    @php
                        $counter++;
                    @endphp
                @endfor
            @endforeach

        </div>

        <script>
            setTimeout(function() {
                window.print();
            }, 500);
        </script>
    </body>

</html>
