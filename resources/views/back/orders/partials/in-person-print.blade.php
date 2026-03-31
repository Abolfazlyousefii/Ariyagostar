@php
    $pageWidth = 80;
    $pageHeight = 210;
@endphp
<!DOCTYPE html>
<html lang="fa">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>فاکتور فروش</title>

        <link rel="stylesheet" href="{{ asset('back/assets/fonts/vazir/style.css') }}">
        <style>
            * {
                box-sizing: border-box;
            }

            @media screen {
                .factor-container {
                    width: 8cm;
                    margin: auto
                }
            }

            body {
                margin: 0;
                padding: 0;
                direction: rtl;
                font-size: 8px;
            }

            .factor-container {
                box-sizing: border-box;
                padding-top: 0;
            }

            .factor-title {
                font-weight: 700;
                text-align: center;
                margin: 10px 0;
            }

            .site-title {
                text-align: center;
                margin-bottom: 10px;
                margin-top: 0;
            }

            .date-container {
                display: flex;
                justify-content: space-between;
            }

            .page-break {
                page-break-after: always;
            }

            td,
            th {
                border: 1px solid black;
                padding: 3px;
                font-size: 8px;
            }

            table {
                border-collapse: separate;
                width: 100%;
            }

            .ltr {
                direction: ltr;
                text-align: left;
            }

            .factor-detail {
                display: flex;
                justify-content: space-between;
            }

            .no-border {
                border: none;
            }

            .text-left {
                text-align: left;
            }

            .text-center {
                text-align: center;
            }

            .footer-detail {
                text-align: center;
                margin-top: 10px;
            }

            .footer-detail h2 {
                margin: 0;
            }

            .footer-detail p {
                margin: 0;
            }

            .footer-detail .phone {
                display: flex;
                justify-content: center;
            }

            .footer-detail .phone .ltr {
                display: flex;
                justify-content: center;
            }

            .product-title {
                font-size: 8px;
            }
        </style>
    </head>

    <body>
        <div class="factor-container">
            {{-- <h3 class="factor-title">فاکتور فروش</h3> --}}
            <h2 class="site-title">{{ option('in_person_factor_title') }}</h2>
            <div class="date-container">
                <div>
                    <strong>شماره فاکتور: </strong><span>{{ $order->id }}</span>
                </div>
                <div>
                    <strong>تاریخ: </strong><span>{{ jdate($order->created_at)->format('Y/m/d') }}</span>
                </div>
            </div>
            <hr>
            @if ($order->name && $order->name != ' ')
                <div>
                    <strong>خریدار:</strong><span>{{ $order->name }}</span>
                </div>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>عنوان کالا</th>
                        <th>تعداد</th>
                        <th>بهای واحد</th>
                        <th>بهای کل</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="product-title">{{ $item->title }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="ltr">{{ number_format($item->price) }}</td>
                            <td class="ltr">{{ number_format($item->price * $item->quantity) }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td class="no-border">تعداد اقلام: {{ $order->items()->count() }}</td>
                        <td class="no-border"></td>
                        <td class="no-border text-left">جمع:</td>
                        <td class="ltr">{{ number_format($order->price + $order->discount_amount) }}</td>
                    </tr>
                    <tr>
                        <td class="no-border">تعداد کل: {{ $order->items()->sum('quantity') }}</td>
                        <td class="no-border"></td>
                        <td class="no-border text-left">تخفیف:</td>
                        <td class="ltr">{{ number_format($order->discount_amount) }}</td>
                    </tr>
                    @if ($order->tax)
                        <tr>
                            <td class="no-border"></td>
                            <td class="no-border"></td>
                            <td class="no-border text-left">مالیات:</td>
                            <td class="ltr">{{ $order->tax }}%</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="no-border"></td>
                        <td class="no-border"></td>
                        <td class="no-border text-left">جمع کل:</td>
                        <td class="ltr">{{ number_format($order->price) }}</td>
                    </tr>
                </tbody>
            </table>

            <div>
                <hr>
                <span>جمع کل فاکتور بحروف:</span>
                <span>{{ convert_number($order->price) }} تومان</span>
            </div>

            <div class="footer-detail">
                {!! option('in_person_factor_footer') !!}
            </div>
        </div>

        <script>
            setTimeout(function() {
                window.print();
            }, 500);
        </script>
    </body>

</html>
