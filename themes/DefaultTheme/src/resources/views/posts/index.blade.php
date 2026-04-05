@extends('front::layouts.master', ['title' => trans('front::messages.posts.blog')])

@push('meta')
    @if(option('allow_indexing_blog_page') == "off")
        <meta name="robots" content="noindex, nofollow">
        <meta name="googlebot" content="noindex, nofollow">
        <meta name="bingbot" content="noindex, nofollow">
    @else
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta name="bingbot" content="index, follow">
    @endif

    <meta name="description" content="Explore expert insights, product stories, and practical guides to help you make better buying decisions.">
    <meta property="og:title" content="{{ trans('front::messages.posts.blog') }} | {{ option('info_site_title') }}">
    <meta property="og:description" content="Explore expert insights, product stories, and practical guides to help you make better buying decisions.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('front.posts.index') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ trans('front::messages.posts.blog') }} | {{ option('info_site_title') }}">
    <meta name="twitter:description" content="Explore expert insights, product stories, and practical guides to help you make better buying decisions.">
    <link rel="canonical" href="{{ route('front.posts.index') }}">

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Blog",
            "name": "{{ trans('front::messages.posts.blog') }}",
            "description": "Explore expert insights, product stories, and practical guides to help you make better buying decisions.",
            "url": "{{ route('front.posts.index') }}",
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
                <a href="#" aria-current="page">{{ trans('front::messages.posts.blog') }}</a>
            </nav>

            <section class="premium-blog__hero dt-sn" aria-labelledby="blog-main-heading">
                <div class="premium-blog__hero-content">
                    <p class="premium-blog__eyebrow">Editorial Hub</p>
                    <h1 id="blog-main-heading">Insights, stories, and practical guides</h1>
                    <p class="premium-blog__subtitle">
                        Discover curated articles from our team on trends, product education, and useful tips that help you choose smarter.
                    </p>
                    <a class="btn btn-primary premium-blog__hero-cta" href="#blog-listing">Browse latest articles</a>
                </div>

                @if($featuredPost)
                    <article class="premium-blog__featured" aria-label="Featured article">
                        <div class="premium-blog__featured-image-wrap">
                            <img
                                loading="lazy"
                                src="{{ $featuredPost->image ? asset($featuredPost->image) : theme_asset('images/blog-empty-image.jpg') }}"
                                alt="{{ $featuredPost->title }}"
                            >
                        </div>
                        <div class="premium-blog__featured-content">
                            <span class="premium-blog__chip">Featured</span>
                            <h2>
                                <a href="{{ route('front.posts.show', ['post' => $featuredPost]) }}">{{ $featuredPost->title }}</a>
                            </h2>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($featuredPost->short_description ?: $featuredPost->content), 140) }}</p>
                        </div>
                    </article>
                @endif
            </section>

            <section class="premium-blog__filters dt-sn" aria-label="Blog filters">
                <form action="{{ route('front.posts.index') }}" method="get" id="blog-filter-form" class="premium-blog__filters-form">
                    <label class="sr-only" for="blog-search">Search articles</label>
                    <div class="premium-blog__search-wrap">
                        <i class="mdi mdi-magnify" aria-hidden="true"></i>
                        <input
                            id="blog-search"
                            name="q"
                            type="search"
                            value="{{ $searchTerm }}"
                            class="premium-blog__search"
                            placeholder="Search by title, keyword, or topic"
                            maxlength="120"
                        >
                    </div>

                    <div class="premium-blog__categories" role="group" aria-label="Categories">
                        <a href="{{ route('front.posts.index', ['q' => $searchTerm ?: null]) }}" class="premium-blog__category {{ !$activeCategoryId ? 'is-active' : '' }}">
                            All
                        </a>
                        @foreach($categories as $category)
                            <a
                                href="{{ route('front.posts.index', ['q' => $searchTerm ?: null, 'category' => $category->id]) }}"
                                class="premium-blog__category {{ (int) $activeCategoryId === (int) $category->id ? 'is-active' : '' }}"
                            >
                                {{ $category->title }}
                            </a>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary premium-blog__search-submit">Search</button>
                </form>
            </section>

            @if($errors->any())
                <div class="alert alert-danger mt-3" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <section id="blog-listing" class="premium-blog__listing" aria-live="polite" aria-busy="false">
                <div class="premium-blog__listing-head">
                    <h2>Latest articles</h2>
                    <p>{{ $posts->total() }} article{{ $posts->total() === 1 ? '' : 's' }} found</p>
                </div>

                @if($posts->count())
                    <div class="row">
                        @foreach ($posts as $post)
                            @php
                                $excerpt = \Illuminate\Support\Str::limit(strip_tags($post->short_description ?: $post->content), 120);
                                $readingTime = max(1, (int) ceil(str_word_count(strip_tags($post->content)) / 220));
                            @endphp
                            <div class="col-xl-4 col-md-6 col-12 mb-4 d-flex">
                                <article class="premium-post-card dt-sn w-100">
                                    <a class="premium-post-card__media" href="{{ route('front.posts.show', ['post' => $post]) }}" aria-label="Read {{ $post->title }}">
                                        <img
                                            loading="lazy"
                                            src="{{ $post->image ? asset($post->image) : theme_asset('images/blog-empty-image.jpg') }}"
                                            alt="{{ $post->title }}"
                                        >
                                    </a>

                                    <div class="premium-post-card__body">
                                        <div class="premium-post-card__meta">
                                            <span class="premium-post-card__category">{{ $post->category ? $post->category->title : trans('front::messages.posts.uncategorized') }}</span>
                                            <span>{{ jdate($post->created_at)->format('%d %B %Y') }}</span>
                                            <span>{{ $readingTime }} min read</span>
                                        </div>

                                        <h3>
                                            <a href="{{ route('front.posts.show', ['post' => $post]) }}">{{ $post->title }}</a>
                                        </h3>

                                        <p>{{ $excerpt }}</p>

                                        <a class="premium-post-card__cta" href="{{ route('front.posts.show', ['post' => $post]) }}">
                                            Continue reading
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
                        <h3>No articles found</h3>
                        <p>Try changing your filters or search term to discover more content.</p>
                        <a href="{{ route('front.posts.index') }}" class="btn btn-primary">Reset filters</a>
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

            if (!form || !listing) {
                return;
            }

            form.addEventListener('submit', function() {
                listing.setAttribute('aria-busy', 'true');
            });
        })();
    </script>
@endpush
