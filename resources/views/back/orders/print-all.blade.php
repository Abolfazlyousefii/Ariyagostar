@extends('back.layouts.printable')

@push('styles')
    <style>
        @media print {
            @page {
                size: landscape
            }

            .single-order-form {
                page-break-after: always;
            }

            .table .print-factor td,
            .table .print-factor th {
                background-color: #dde2e1 !important;
            }
        }

        .table tr td,
        .table tr th {
            padding: .2rem;
            padding-right: .6rem;
            font-size: 14px
        }

        .table td.Space,
        .table th.Space {
            padding-bottom: 1rem;
        }

        ul.list-unstyled {
            margin-bottom: 8px
        }

        strong.title {
            margin-bottom: 5px;
            display: block;
            font-size: 14px;
        }

        .factor-header-info {
            white-space: nowrap;
        }
        .factor-header-info b {
            font-size: 12px;
        }
        img {
            max-width: 100%;
        }

    </style>
@endpush

@section('content')
    <div class="container pt-1">
        @foreach ($orders as $order)
            @if ($order->hasPhysicalProduct())
                @include('back.orders.partials.print')
            @endif
        @endforeach
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
        setTimeout(function () { window.print(); }, 500);
    </script>
@endpush
