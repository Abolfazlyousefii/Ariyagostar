<div class="ah-tab-content comments-tab dt-sl">

    <div class="dt-sl">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="comments-summary-note">
                    <span>{{ trans('front::messages.reviews.you-can-also-comment') }}</span>
                    <p>{{ trans('front::messages.reviews.login-to-submit-comment') }}</p>
                    <div class="dt-sl mt-2 mb-4">
                        @if (auth()->check())
                            <button data-toggle="modal" data-target="#add-product-review-modal" class="btn-primary-cm btn-with-icon">
                                <i class="mdi mdi-comment-text-outline"></i>
                                {{ trans('front::messages.reviews.add-review') }}
                            </button>
                        @else
                            <a href="{{ route('login', ['redirect', route('front.products.show', ['product' => $product])]) }}" class="btn-primary-cm btn-with-icon">
                                <i class="mdi mdi-comment-text-outline"></i>
                                {{ trans('front::messages.reviews.add-review') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if ($reviews->count())
            <div class="comments-area dt-sl">
                <div class="section-title text-sm-title title-wide no-after-title-wide mb-0 dt-sl">
                    <h2>{{ trans('front::messages.reviews.user-comments') }}</h2>
                    <p class="count-comment"><span class="rate-product">{{ trans('front::messages.reviews.reviews-count', ['rating' => $product->rating, 'review_count' => $product->reviews_count]) }}</span></p>
                </div>
                <ol class="comment-list">
                    @foreach ($reviews as $review)
                        <!-- #comment-## -->
                        <li>
                            <div class="comment-body">
                                <div class="row">

                                    <div class="col-md-12 col-sm-12 comment-content">
                                        <div class="comment-title">
                                            {{ $review->title }}
                                        </div>
                                        <div class="comment-author">
                                            توسط {{ $review->user->fullname }} در تاریخ {{ jdate($review->created_at)->format('%d %B %Y') }}
                                            @if ($review->suggest)
                                                <span class="badge badge-success">خریدار</span>
                                            @endif
                                        </div>


                                        <p>{!! nl2br(htmlentities($review->body)) !!}</p>

                                        @if ($review->points->count())
                                            <div class="row">
                                                @if ($review->points->where('type', 'positive')->count())
                                                    <div class="col-md-4 col-sm-6 col-12">
                                                        <div class="content-expert-evaluation-positive">
                                                            <span>نقاط قوت</span>
                                                            <ul>
                                                                @foreach ($review->points->where('type', 'positive') as $point)
                                                                    <li>{{ $point->text }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($review->points->where('type', 'negative')->count())
                                                    <div class="col-md-4 col-sm-6 col-12">
                                                        <div class="content-expert-evaluation-negative">
                                                            <span>نقاط ضعف</span>
                                                            <ul>
                                                                @foreach ($review->points->where('type', 'negative') as $point)
                                                                    <li>{{ $point->text }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        @switch($review->suggest)
                                            @case('yes')
                                                <div class="user-suggest text-success"><i class="mdi mdi-thumb-up-outline"></i> پیشنهاد می کنم</div>
                                                @break
                                            @case('not_sure')
                                                <div class="user-suggest text-muted"><i class="mdi mdi-help"></i> مطمئن نیستم</div>
                                                @break
                                            @case('no')
                                                <div class="user-suggest text-danger"><i class="mdi mdi-thumb-down-outline"></i> پیشنهاد نمی کنم</div>
                                                @break

                                        @endswitch

                                        <div class="footer">
                                            <div class="comments-likes">
                                                <button data-action="{{ route('front.reviews.like', ['review' => $review]) }}" class="btn-like">
                                                    <span class="likes-count">{{ $review->likes_count }}</span> <i class="mdi mdi-thumb-up-outline"></i>
                                                </button>
                                                <button data-action="{{ route('front.reviews.dislike', ['review' => $review]) }}" class="btn-like">
                                                    <span class="dislikes-count">{{ $review->dislikes_count }}</span> <i class="mdi mdi-thumb-down-outline"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        @endif
    </div>
</div>
