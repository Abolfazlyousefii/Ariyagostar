@extends('front::layouts.master', ['title' => $post->meta_title ?: $post->title])

@push('meta')
    @if(option('allow_indexing_blog_page') =="off" )
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="bingbot" content="noindex, nofollow">

    @else
    <meta name="robots" content="index, follow"/>
    <meta name="googlebot" content="index, follow">
    <meta name="bingbot" content="index, follow">
    @endif
    <meta property="og:title" content="{{ $post->meta_title ?: $post->title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ route('front.blog.show', ['post' => $post]) }}" />
    <meta name="description" content="{{ $post->meta_description ?: $post->short_description }}">
    <meta name="keywords" content="{{ $post->getTags }}">
    <link rel="canonical" href="{{ route('front.blog.show', ['post' => $post]) }}" />

    @if ($post->image)
        <meta property="og:image" content="{{ asset($post->image) }}">
    @endif

@endpush

@section('content')

    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container main-container">

            <div class="row">
                <div class="col-12">
                    <!-- Start title - breadcrumb -->
                    <div class="title-breadcrumb-special dt-sl">
                        <div class="breadcrumb dt-sl">
                            <nav>
                                <a href="/">{{ trans('front::messages.posts.home') }}</a>
                                <a href="{{ route('front.blog.index') }}">{{ trans('front::messages.posts.blog') }}</a>
                                <a href="#">{{ $post->title }}</a>
                            </nav>
                        </div>
                        <div class="title-page dt-sl pb-3">
                            <h1>{{ $post->title }}</h1>
                        </div>

                    </div>
                    <!-- End title - breadcrumb -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-12 col-12 mb-3">
                    <div class="content-page">
                        <div class="content-desc dt-sn dt-sl">
                            <header class="entry-header dt-sl mb-3">
                                <div class="post-meta date">
                                    <i class="mdi mdi-calendar-month"></i>{{ jdate($post->created_at)->format('%d %B %Y') }}
                                </div>

                                @if($post->category)
                                    <div class="post-meta category">
                                        <i class="mdi mdi-folder"></i>

                                        <a href="{{ route('front.blog.category', ['category' => $post->category]) }}">{{ $post->category->title }}</a>
                                    </div>
                                @endif
                                <div class="post-meta category">
                                    <i class="mdi mdi-eye"></i>
                                    {{ $post->view }} {{ trans('front::messages.posts.visit') }}
                                </div>
                            </header>

                            @if($post->image)
                                <div class="post-thumbnail dt-sl">
                                    <img class="w-100" data-src="{{ $post->image }}" alt="{{ $post->title }}">
                                </div>
                            @endif

                            <div class="col-12 mt-4">
                                {!! $post->content !!}

                            </div>
                        </div>
                    </div>

                    <div class="dt-sl mt-3">
                        @include('front::components.comments', ['model' => $post, 'route_link' => route('front.post.comments', ['post' => $post]) ])
                    </div>

                </div>

                @include('front::posts.partials.sidebar')

            </div>

        </div>
    </main>
    <!-- End main-content -->
@endsection

@push('scripts')
    <script src="{{ theme_asset('js/pages/comments.js') }}"></script>
@endpush
