@extends('front::user.layouts.master')

@section('user-content')
    <!-- Start Content -->
    <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                    <h2>نظرات شما</h2>
                </div>
                <div class="dt-sl reviews-container">
                    <div class="row">
                        @if($reviews->count())
                            @foreach($reviews as $review)
                                <div class="col-lg-6 col-md-12">
                                    <div class="card-horizontal-product">
                                        <div class="card-horizontal-product-thumb">
                                            <a title="{{ $review->product->title }}" href="{{ route('front.products.show', ['product' => $review->product]) }}">
                                                <img src="{{ $review->product->imageUrl() }}" alt="{{ $review->product->title }}">
                                            </a>
                                            <small class="font-weight-bold">امتیاز من به محصول</small>
                                            <div class="rating-stars">
                                                <i class="mdi mdi-star active"></i>
                                                <i class="mdi mdi-star {{ $review->rating > 1 ? 'active' : '' }}"></i>
                                                <i class="mdi mdi-star {{ $review->rating > 2 ? 'active' : '' }}"></i>
                                                <i class="mdi mdi-star {{ $review->rating > 3 ? 'active' : '' }}"></i>
                                                <i class="mdi mdi-star {{ $review->rating > 4 ? 'active' : '' }}"></i>
                                            </div>
                                        </div>
                                        <div class="card-horizontal-product-content">
                                            @switch($review->status)
                                                @case('accepted')
                                                    <div class="label-status-comment">تایید شده</div>
                                                    @break
                                                @case('pending')
                                                    <div class="label-status-comment">منتظر تایید</div>
                                                    @break
                                                @case('rejected')
                                                    <div class="label-status-comment">رد شده</div>
                                                    @break

                                            @endswitch

                                            <div class="card-horizontal-comment-title">
                                                <a href="{{ route('front.products.show', ['product' => $review->product]) }}">
                                                    <h3>{{ $review->title }}</h3>
                                                </a>
                                            </div>
                                            <div class="card-horizontal-comment">
                                                <p>{!! nl2br(htmlentities($review->body)) !!}</p>
                                            </div>
                                            <div class="card-horizontal-product-buttons">
                                                <div class="float-right">
                                                    <span class="count-like">
                                                        <i class="mdi mdi-thumb-up-outline"></i>{{ $review->likes_count }}
                                                    </span>
                                                    <span class="count-like">
                                                        <i class="mdi mdi-thumb-down-outline"></i>{{ $review->dislikes_count }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach



                        @else
                            <div class="col-12">
                                <div class="page dt-sl dt-sn pt-3">
                                    <p>چیزی برای نمایش وجود ندارد</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3">
            {{ $reviews->links('front::components.paginate') }}
        </div>

    </div>
    <!-- End Content -->
@endsection
