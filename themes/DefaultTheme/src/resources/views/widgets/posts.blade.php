@php
    $variables      = get_widget($widget);
    $posts          = $variables['posts'];
@endphp

<!-- Start posts -->
@if ($posts->count())
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <section class="slider-section dt-sl mb-3">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="section-title text-sm-title title-wide no-after-title-wide">
                            <h2>{{ $widget->option('title') }}</h2>
                            @if ($widget->option('link'))
                                <a href="{{ $widget->option('link') }}">{{ $widget->option('link_title', trans('front::messages.user.see-all') ) }}</a>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 px-res-0">
                        <div class="product-carousel carousel-md owl-carousel owl-theme posts-widget-owl">
                            @foreach ($posts as $post)
                                <div class="item">
                                    <div class="post-card mb-0">
                                        <div class="post-thumbnail">
                                            <a href="{{ route('front.posts.show', ['post' => $post]) }}">
                                                <img src="{{ theme_asset('images/blog-empty-image.jpg') }}" data-src="{{ $post->image ? asset($post->image) : theme_asset('images/blog-empty-image.jpg') }}" alt="{{ $post->title }}">
                                            </a>
                                            <span class="post-tag">{{ $post->category ? $post->category->title : trans('front::messages.user.uncategorized')  }}</span>

                                        </div>
                                        <div class="post-title">
                                            <a href="{{ route('front.posts.show', ['post' => $post]) }}">{{ $post->title }}</a>
                                            <span class="post-date">{{ jdate($post->created_at)->format('%d %B %Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endif
<!-- End posts -->
