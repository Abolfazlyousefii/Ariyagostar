@foreach ($options as $option)

    @switch($option['input-type'])
        @case('input')
            @include('back.widgets.partials.input')
            @break

        @case('file')
            @include('back.widgets.partials.file')
            @break

        @case('select')
            @include('back.widgets.partials.select')
            @break

        @case('product_categories')
            @include('back.widgets.partials.product-categories')
            @break

        @case('post_categories')
            @include('back.widgets.partials.post-categories')
            @break

        @case('discount_products')
            @include('back.widgets.partials.discount-products')
            @break

        @case('custom-page')
            @include('back.widgets.partials.custom-page')
            @break

    @endswitch

@endforeach
