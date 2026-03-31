@extends('front::layouts.master', ['title' => $category->title])

@push('meta')
    <link rel="canonical" href="{{ route('front.posts.category', ['category' => $category]) }}" />
@endpush

@section('content')
    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container main-container">
            <div class="row">
                <div class="col-12">
                    <!-- Start Content -->
                    <div class="title-breadcrumb-special dt-sl mb-3">
                       <div class="breadcrumb dt-sl">
                           <nav>
                               <a href="/">{{ trans('front::messages.posts.home') }}</a>
                               <a href="{{ route('front.posts.index') }}">{{ trans('front::messages.posts.blog') }}</a>
                               <a href="#">{{ $category->title }}</a>
                           </nav>
                       </div>
                   </div>
               </div>
            </div>

            <div class="row">

                <div class="col-lg-9 col-md-8 col-sm-12 col-12 mb-3">

                    @if($posts->count())
                        <div class="row mt-5">
                            @foreach ($posts as $post)

                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                    <div class="post-card">
                                        <div class="post-thumbnail">
                                            <a href="{{ route('front.posts.show', ['post' => $post]) }}">
                                                <img data-src="{{ $post->image ? $post->image : theme_asset('images/blog-empty-image.jpg') }}" alt="{{ $post->title }}">
                                            </a>
                                            <span class="post-tag">{{ $post->category ? $post->category->title : trans('front::messages.posts.uncategorized') }}</span>

                                        </div>
                                        <div class="post-title">
                                            <a href="{{ route('front.posts.show', ['post' => $post]) }}">{{ $post->title }}</a>
                                            <span class="post-date">{{ jdate($post->created_at)->format('%d %B %Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="row">
                            <div class="col-12">
                                <div class="page dt-sl dt-sn pt-3">
                                    <p>{{ trans('front::messages.posts.there-is-nothing-to-show') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif


                    {{ $posts->links('front::components.paginate') }}

                </div>

                @include('front::posts.partials.sidebar')
            </div>

        </div>
    </main>
    <!-- End main-content -->
@endsection
