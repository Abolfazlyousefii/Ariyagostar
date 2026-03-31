@extends('front::user.layouts.master')

@section('user-content')
    <!-- Start Content -->
    <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                    <h2>{{ trans('front::messages.user.your-views') }}</h2>
                </div>
                <div class="dt-sl">
                    <div class="row">
                        @if($comments->count())
                            @foreach($comments as $comment)
                                <div class="col-lg-6 col-md-12">
                                    <div class="card-horizontal-product">

                                        <div class="card-horizontal-product-content">
                                            <div class="label-status-comment">
                                                @if($comment->status == 'pending')
                                                    <div class="text-warning">{{ trans('front::messages.user.waiting-for-confirmation') }}</div>
                                                @elseif($comment->status == 'accepted')
                                                    <div class="text-success">{{ trans('front::messages.user.accepted') }}</div>
                                                @else
                                                    <div class="text-danger">{{ trans('front::messages.user.not-approved') }}</div>
                                                @endif
                                            </div>
                                            <div class="card-horizontal-comment-title">
                                                @if ($comment->commentable)
                                                    <a href="{{ $comment->commentable->link() }}">
                                                        <h3> {{ trans('front::messages.user.at') }} {{ $comment->commentable->title }}</h3>
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="card-horizontal-comment">
                                                <p>{!! nl2br(htmlentities($comment->body)) !!}</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @else
                            <div class="col-12">
                                <div class="page dt-sl dt-sn pt-3">
                                    <p>{{ trans('front::messages.user.there-nothing-to-show') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->
@endsection
