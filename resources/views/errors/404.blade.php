@if (!config()->has('front.errors.404'))
    @include('errors.404-admin')
@else
    @include(config('front.errors.404'))
@endif

