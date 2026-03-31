@extends('front::layouts.master', ['title' => trans('front::messages.products.product-comparison')])

@push('meta')
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex">
@endpush

@section('content')
    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container main-container">

            <div class="comparison-table">
                <table class="table">
                    <thead>
                        <tr>
                            <td class="align-middle">
                                @if ($products->count() < 3)
                                    <div class="comparison-item">
                                        <a class="comparison-item-thumb py-3" href="#" data-toggle="modal" data-target="#compareModal">
                                            <img src="{{ theme_asset('images/plus.svg') }}">
                                        </a>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#compareModal">{{ trans('front::messages.products.add-product-for-comparison') }}</button>
                                    </div>
                                @endif

                            </td>
                            @foreach ($products as $product)
                                <td>
                                    <div class="comparison-item">
                                        @if ($products->count() > 1)
                                            <a href="{{ remove_id_from_url($product->id) }}">
                                                <span class="remove-item"><i class="mdi mdi-close"></i></span>
                                            </a>
                                        @endif
                                        <a class="comparison-item-thumb" href="{{ route('front.products.show', ['product' => $product]) }}">
                                            <img src="{{ $product->image }}" alt="{{ $product->title }}">
                                        </a>
                                        <a class="comparison-item-title" href="{{ route('front.products.show', ['product' => $product]) }}">{{ $product->title }}</a>
                                        <a class="btn btn-primary btn-sm" href="{{ route('front.products.show', ['product' => $product]) }}">{{ trans('front::messages.products.view-product') }}</a>
                                    </div>
                                </td>
                            @endforeach

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($groups as $group)
                            <tr class="bg-cs-table-tr">
                                <th class="text-uppercase">{{ $group->name }}</th>

                                @foreach ($products as $product)
                                    <td><span class="text-medium"> {{ $product->title }}</span></td>
                                @endforeach
                            </tr>
                            @php
                                $specifications = \DB::table('product_specification')
                                    ->where('specification_group_id', $group->id)
                                    ->whereIn('product_id', $products->pluck('id'))
                                    ->orderBy('group_ordering')
                                    ->get();
                            @endphp

                            @foreach ($specifications->unique('specification_id') as $specification)
                                @php
                                    $spec = \DB::table('specifications')->find($specification->specification_id);
                                @endphp

                                <tr>
                                    <th>{{ $spec->name }}</th>

                                    @foreach ($products as $product)
                                        @php
                                            $specification_value = $specifications
                                                ->where('specification_id', $spec->id)
                                                ->where('product_id', $product->id)
                                                ->first();
                                        @endphp

                                        <td>{{ $specification_value ? $specification_value->value : '-' }}</td>
                                    @endforeach

                            @endforeach

                        @endforeach

                        <tr>
                            <th></th>
                            @foreach ($products as $product)
                                <td>
                                    <a class="btn btn-primary btn-sm btn-block" href="{{ route('front.products.show', ['product' => $product]) }}">{{ trans('front::messages.products.compare-show-product') }}</a>
                                </td>
                            @endforeach

                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </main>
    <!-- End main-content -->

    @if ($products->count() < 3)
        @php
          $similar_products = \App\Models\Product::published()->whereNotIn('id', $products->pluck('id'))
                ->where('spec_type_id', $products->first()->spec_type_id)
                ->orderByStock()
                ->take(12)
                ->get();
        @endphp

        @include('front::products.partials.compare-modal', [
            'similar_products' => $similar_products,
            'current_url' => url()->current(),
        ])
    @endif
@endsection

@push('scripts')
    <script src="{{ theme_asset('js/pages/products/compare.js') }}"></script>
@endpush
