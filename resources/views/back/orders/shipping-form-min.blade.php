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
        p{
            font-size: 10px
        }

    </style>
@endpush

@section('content')
    <div class="container pt-1">
        @include('back.orders.partials.shipping-form-min')
    </div>
@endsection

@push('scripts')
    <script>
        setTimeout(function () { window.print(); }, 500);
    </script>
@endpush
