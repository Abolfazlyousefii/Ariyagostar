@extends('back.layouts.printable')

@push('styles')
    <style>
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #181818;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row" dir="rtl">
            <div class="col-12 text-center mb-2">
                <strong>موجودی کالاها تاریخ {{ jdate()->format('d-m-Y') }}</strong>
            </div>
            <div class="col-12 p-0">
                <table class="table table-bordered">
                    <thead>
                        <tr class="print-factor factor-table-color">
                            <th class="text-center" style="width: 50px">کد</th>
                            <th style="width: 250px">محصول</th>
                            <th class="text-center" style="width: 70px"><small>موجودی</small></th>
                            <th class="text-center" style="width: 70px"><small>تعداد کسر یا اضافه</small></th>
                            <th class="text-center" style="width: 70px"><small>موجودی نهایی</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            @foreach ($product->prices as $price)
                                @php
                                    if (request()->input('query.stock') == 'available' && $price->stock <= 0) {
                                        continue;
                                    }
                                @endphp

                                <tr>
                                    <td class="text-center">{{ $price->id }}</td>
                                    <td>{{ $product->title }} <br> {{ $price->getAttributesName() }}</td>
                                    <td class="text-center">{{ $price->stock }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="container p-0 mt-1 d-print-none">
        <div class="row">
            <div class="col-12 text-right">
                <button onclick="window.print();" class="btn btn-light">چاپ</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        setTimeout(function() {
            window.print();
        }, 500);
    </script>
@endpush
