@extends('front::layouts.master', ['title' => isset($page) ? $page->title : trans('front::messages.posts.blog')])

@php
    $metaDescription = trans('front::messages.posts.blog-meta-description');
    $blogBaseUrl = $blogBaseUrl ?? route('front.blog.index');
    $allowIndexing = isset($page) ? option('allow_indexing_page_id_' . $page->id) !== 'off' : option('allow_indexing_blog_page') !== 'off';
    $canonicalQuery = request()->except('page');
    $queryString = http_build_query(array_filter($canonicalQuery, function ($value) {
        return $value !== null && $value !== '';
    }));
    $canonicalUrl = $queryString ? $blogBaseUrl . '?' . $queryString : $blogBaseUrl;
    $buildBlogUrl = function (array $params = []) use ($blogBaseUrl) {
        $query = http_build_query(array_filter($params, function ($value) {
            return $value !== null && $value !== '';
        }));

        return $query ? $blogBaseUrl . '?' . $query : $blogBaseUrl;
    };
@endphp

@push('meta')
    @if(!$allowIndexing)
        <meta name="robots" content="noindex, nofollow">
        <meta name="googlebot" content="noindex, nofollow">
        <meta name="bingbot" content="noindex, nofollow">
    @else
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta name="bingbot" content="index, follow">
    @endif

    <meta name="description" content="{{ $metaDescription }}">
    <meta property="og:title" content="{{ trans('front::messages.posts.blog') }} | {{ option('info_site_title') }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    @if($featuredPost && $featuredPost->image)
        <meta property="og:image" content="{{ asset($featuredPost->image) }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ trans('front::messages.posts.blog') }} | {{ option('info_site_title') }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Blog",
            "name": "{{ trans('front::messages.posts.blog') }}",
            "description": "{{ $metaDescription }}",
            "url": "{{ $canonicalUrl }}",
            "publisher": {
                "@type": "Organization",
                "name": "{{ option('info_site_title') }}"
            }
        }
    </script>
@endpush

@section('content')
    <main class="main-content dt-sl mt-4 mb-3 premium-blog" aria-labelledby="blog-main-heading">
        <div class="container main-container">
            <nav class="breadcrumb dt-sl premium-blog__breadcrumb" aria-label="Breadcrumb">
                <a href="/">{{ trans('front::messages.posts.home') }}</a>
                <a href="{{ $blogBaseUrl }}" aria-current="page">{{ trans('front::messages.posts.blog') }}</a>
            </nav>

            <section class="premium-blog__hero dt-sn" aria-labelledby="blog-main-heading">
                <div class="premium-blog__hero-content">
                    <p class="premium-blog__eyebrow">{{ trans('front::messages.posts.hero-eyebrow') }}</p>
                    <h1 id="blog-main-heading">{{ trans('front::messages.posts.hero-title') }}</h1>
                    <p class="premium-blog__subtitle">{{ trans('front::messages.posts.hero-description') }}</p>
                    <a class="btn btn-primary premium-blog__hero-cta" href="#blog-listing">{{ trans('front::messages.posts.hero-cta') }}</a>
                </div>

                @if($featuredPost)
                    @php
                        $featuredImage = $featuredPost->image ? asset($featuredPost->image) : theme_asset('images/blog-empty-image.jpg');
                    @endphp
                    <article class="premium-blog__featured" aria-label="{{ trans('front::messages.posts.featured-post') }}">
                        <div class="premium-blog__featured-image-wrap">
                            <img loading="lazy" src="{{ $featuredImage }}" alt="{{ $featuredPost->title }}">
                        </div>
                        <div class="premium-blog__featured-content">
                            <span class="premium-blog__chip">{{ trans('front::messages.posts.featured') }}</span>
                            <h2>
                                <a href="{{ route('front.blog.show', ['post' => $featuredPost]) }}">{{ $featuredPost->title }}</a>
                            </h2>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($featuredPost->short_description ?: $featuredPost->content), 140) }}</p>
                        </div>
                    </article>
                @endif
            </section>

            <section class="premium-blog__filters dt-sn" aria-label="{{ trans('front::messages.posts.blog-filters') }}">
                <form action="{{ $blogBaseUrl }}" method="get" id="blog-filter-form" class="premium-blog__filters-form">
                    <label class="sr-only" for="blog-search">{{ trans('front::messages.posts.search-label') }}</label>
                    <div class="premium-blog__search-wrap">
                        <i class="mdi mdi-magnify" aria-hidden="true"></i>
                        <input
                            id="blog-search"
                            name="q"
                            type="search"
                            value="{{ $searchTerm }}"
                            class="premium-blog__search"
                            placeholder="{{ trans('front::messages.posts.search-placeholder') }}"
                            maxlength="120"
                            aria-label="{{ trans('front::messages.posts.search-label') }}"
                        >
                    </div>

                    <div class="premium-blog__categories" role="group" aria-label="{{ trans('front::messages.posts.categories') }}">
                        <a href="{{ $buildBlogUrl(['q' => $searchTerm ?: null]) }}" class="premium-blog__category {{ !$activeCategoryId ? 'is-active' : '' }}">
                            {{ trans('front::messages.posts.all-categories') }}
                        </a>
                        @foreach($categories as $category)
                            <a
                                href="{{ $buildBlogUrl(['q' => $searchTerm ?: null, 'category' => $category->id]) }}"
                                class="premium-blog__category {{ (int) $activeCategoryId === (int) $category->id ? 'is-active' : '' }}"
                            >
                                {{ $category->title }}
                            </a>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary premium-blog__search-submit">{{ trans('front::messages.posts.search') }}</button>
                </form>
            </section>

            @if($errors->any())
                <div class="alert alert-danger mt-3" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <section id="blog-listing" class="premium-blog__listing" aria-live="polite" aria-busy="false">
                <div class="premium-blog__loading" data-loading-text>
                    <i class="mdi mdi-loading mdi-spin" aria-hidden="true"></i>
                    <span>{{ trans('front::messages.posts.loading') }}</span>
                </div>

                <div class="premium-blog__listing-head">
                    <h2>{{ trans('front::messages.posts.latest-articles') }}</h2>
                    <p>{{ trans_choice('front::messages.posts.article-count', $posts->total(), ['count' => $posts->total()]) }}</p>
                </div>

                @if($posts->count())
                    <div class="row">
                        @foreach ($posts as $post)
                            @php
                                $excerpt = \Illuminate\Support\Str::limit(strip_tags($post->short_description ?: $post->content), 120);
                                $wordCount = count(preg_split('/\s+/u', trim(strip_tags($post->content)), -1, PREG_SPLIT_NO_EMPTY));
                                $readingTime = max(1, (int) ceil($wordCount / 220));
                                $postImage = $post->image ? asset($post->image) : theme_asset('images/blog-empty-image.jpg');
                            @endphp
                            <div class="col-xl-4 col-md-6 col-12 mb-4 d-flex">
                                <article class="premium-post-card dt-sn w-100">
                                    <a class="premium-post-card__media" href="{{ route('front.blog.show', ['post' => $post]) }}" aria-label="{{ trans('front::messages.posts.read-article', ['title' => $post->title]) }}">
                                        <img loading="lazy" src="{{ $postImage }}" alt="{{ $post->title }}">
                                    </a>

                                    <div class="premium-post-card__body">
                                        <div class="premium-post-card__meta">
                                            <span class="premium-post-card__category">{{ $post->category ? $post->category->title : trans('front::messages.posts.uncategorized') }}</span>
                                            <span>{{ jdate($post->created_at)->format('%d %B %Y') }}</span>
                                            <span>{{ trans('front::messages.posts.reading-time', ['minutes' => $readingTime]) }}</span>
                                        </div>

                                        <h3>
                                            <a href="{{ route('front.blog.show', ['post' => $post]) }}">{{ $post->title }}</a>
                                        </h3>

                                        <p>{{ $excerpt }}</p>

                                        <a class="premium-post-card__cta" href="{{ route('front.blog.show', ['post' => $post]) }}">
                                            {{ trans('front::messages.posts.continue-reading') }}
                                            <i class="mdi mdi-arrow-left" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>

                    <div class="premium-blog__pagination">
                        {{ $posts->links('front::components.paginate') }}
                    </div>
                @else
                    <div class="premium-blog__empty dt-sn" role="status">
                        <i class="mdi mdi-file-search-outline" aria-hidden="true"></i>
                        <h3>{{ trans('front::messages.posts.empty-title') }}</h3>
                        <p>{{ trans('front::messages.posts.empty-description') }}</p>
                        <a href="{{ $blogBaseUrl }}" class="btn btn-primary">{{ trans('front::messages.posts.reset-filters') }}</a>
                    </div>
                @endif
            </section>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        (function() {
            var form = document.getElementById('blog-filter-form');
            var listing = document.getElementById('blog-listing');
            var loadingText = document.querySelector('[data-loading-text]');

            if (!form || !listing || !loadingText) {
                return;
            }

            loadingText.setAttribute('hidden', 'hidden');

            form.addEventListener('submit', function() {
                listing.setAttribute('aria-busy', 'true');
                loadingText.removeAttribute('hidden');
            });
        })();
    </script>
@endpush
