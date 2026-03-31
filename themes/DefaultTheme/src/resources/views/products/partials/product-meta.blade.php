<meta property="og:locale" content="fa_IR" />
<meta property="og:title" content="{{ $product->meta_title ?: $product->title }}" />
<meta property="og:type" content="product" />
<meta property="og:url" content="{{ route('front.products.show', ['product' => $product]) }}" />
<meta property="og:description" content="{{ $product->meta_description ?: $product->short_description }}">
<meta name="keywords" content="{{ $product->getTags }}">
<meta name="product_id" content="{{ $product->id }}">
<link rel="canonical" href="{{ route('front.products.show', ['product' => $product]) }}" />

<meta name="product_name" content="{{ $product->title }}">
<meta name="product_price" content="{{ $product->getLowestPrice(true, true) }}">
<meta name="product_old_price" content="{{ $product->getLowestDiscount(true, true) }}">

<meta name="price" content="{{ $product->getLowestPrice(true, true) }}">

@if ($product->image)
    <meta property="og:image" content="{{ asset($product->image) }}">
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="600" />
@endif

@if ($product->addableToCart())
    <meta property="product:availability" content="in stock">
    <meta property="product:price:amount" content="{{ $product->getLowestPrice(true, true) }}">
    <meta property="product:price:currency" content="IRR">
    <meta name="availability" content="https://schema.org/InStock">
@else
    <meta property="product:availability" content="out of stock">
    <meta name="availability" content="https://schema.org/OutOfStock">
@endif

<script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "Product",
        "name": "{{ $product->meta_title ?: $product->title }}",
        @if($product->title_en)
        "alternateName": "{{ $product->title_en }}",
        @endif
        "image": [
@php
    $images = collect([$product->image]);
    if ($product->gallery()->count()) {
        $images = $images->merge($product->gallery->pluck('image'));
    }
@endphp
    {!! $images->map(fn($img) => '"' . asset($img) . '"')->implode(', ') !!}
    ],

        @if ($product->brand)
        "brand": {
            "@type": "Brand",
            "name": "{{ $product->brand->name }}"
        },
        @endif

        "offers": {
            "@type": "Offer",
            "url": "{{ route('front.products.show', ['product' => $product]) }}",
            "priceCurrency": "IRR",
            "price": "{{ $product->getLowestPrice(true, true) }}",
            @if ($product->addableToCart())
            "availability": "https://schema.org/InStock"
            @else
            "availability": "https://schema.org/OutOfStock"
            @endif
        },

        "description": {!! json_encode($product->meta_description ?: $product->short_description) !!}
    }
</script>
