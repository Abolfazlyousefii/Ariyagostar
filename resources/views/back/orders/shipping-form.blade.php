@extends('back.layouts.printable')

@push('styles')
    <link rel="stylesheet" href="{{ asset('back/assets/css/pages/orders/print.css') }}?v=3">
    <style>
        @media print {
            @page {
                size: landscape
            }
        }

        .p-border-right {
            border-right: 2px solid #6e7275 !important;
        }

        .p-border-left {
            border-left: 2px solid #6e7275 !important;
        }

        .p-border-top {
            border-top: 2px solid #6e7275 !important;
        }

        .p-border-bottom {
            border-bottom: 2px solid #6e7275 !important;
        }

        .p-border {
            border: 2px solid #6e7275 !important;
        }

    </style>
@endpush

@section('content')
    <div class="container pt-1">
        @include('back.orders.partials.shipping-form')
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
