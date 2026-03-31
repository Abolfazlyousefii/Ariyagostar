@extends('front::layouts.master', ['title' => $page->title])

@push('meta')

@if(option('allow_indexing_page_id_'.$page->id) =="off")
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="bingbot" content="noindex, nofollow">
@else
    <meta name="robots" content="index, follow"/>
    <meta name="googlebot" content="index, follow">
    <meta name="bingbot" content="index, follow">
@endif

    <meta property="og:title" content="{{ $page->title }}" />
    <meta name="keywords" content="{{ $page->getTags }}">
    <link rel="canonical" href="{{ route('front.pages.show', ['page' => $page]) }}" />
@endpush

@section('content')

    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container main-container">

            <div class="row">
                <div class="col-12">
                    <div class="page dt-sl dt-sn pt-3 pb-5">
                        <div class="section-title title-wide mb-1 no-after-title-wide">
                            <h1 class="font-weight-bold">{{ $page->title }}</h1>
                        </div>
                        {!! $page->content !!}
                    </div>
                </div>
            </div>

        </div>
    </main>
    <!-- End main-content -->

@endsection
