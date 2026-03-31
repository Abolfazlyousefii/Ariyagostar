
@auth
    <div class="section-title title-wide no-after-title-wide dt-sl">
        <h2>{{ trans('front::messages.posts.post-a-comment') }}</h2>
    </div>
    <div class="form-question-answer dt-sl mb-3 comment--form">
        <div class="comment-replay-to" style="display: none">
            <span></span> <a href="javasript:void(0)"> {{ trans('front::messages.posts.cancel-reply') }}</a>
        </div>
        <!-- start form -->
        <form id="comments-form" class="cmnt_reply_form" action="{{ $route_link }}" method="post">
            <input type="hidden" name="comment_id">
            <textarea class="form-control mb-3" rows="5" name="body" required></textarea>
            <button type="submit" class="btn btn-dark float-right ml-3 comment-submit-btn">{{ trans('front::messages.posts.submit-a-comment') }}</button>
        </form>
    </div>
@else
    <div class="section-title title-wide no-after-title-wide dt-sl">
        <h2>{{ trans('front::messages.posts.post-a-comment') }}</h2>
        <div class="alert alert-warning" role="alert">
            {{ trans('front::messages.posts.logged-a-comment') }}
        </div>
    </div>

@endauth

<div class="comments-area default">

    @if($model->comments->count())
        <div class="section-title text-sm-title title-wide no-after-title-wide mt-2 mb-0 dt-sl">
            <p class="count-comment">{{ $model->comments()->where('status', 'accepted')->count() }} {{ trans('front::messages.posts.comments') }}</p>
        </div>
        <ol class="comment-list">
            @foreach($model->comments as $comment)

                <li>
                    <div class="comment-body">
                        <div class="comment-author">
                            <span class="icon-comment">?</span>
                            <cite class="fn">{{ $comment->user->fullname }}</cite>
                            <span class="says">{{ trans('front::messages.posts.said') }}</span>
                            <div class="commentmetadata">
                                {{ jdate($comment->created_at)->format('%d %B %Y') }}
                            </div>
                        </div>
                        <p>{!! nl2br(htmlentities($comment->body)) !!}</p>

                        @auth
                            <div class="reply"><a class="comment-reply-link comment-replay" data-name="{{ $comment->user->fullname }}" data-id="{{ $comment->id }}" href="#">پاسخ</a></div>
                        @endauth
                    </div>

                    @php
                        $child_comments = $comment->comments()->where('status', 'accepted')->get()
                    @endphp

                    @if($child_comments->count())
                        <ol class="children">
                            @foreach($child_comments as $child_comment)
                                <li>
                                    <div class="comment-body">
                                        <div class="comment-author">
                                                <span
                                                        class="icon-comment mdi mdi-lightbulb-on-outline"></span>
                                            <cite class="fn">{{ $child_comment->user->fullname }}</cite> <span
                                                    class="says">{{ trans('front::messages.posts.said') }}</span>
                                            <div class="commentmetadata">
                                                {{ jdate($comment->created_at)->format('%d %B %Y') }}
                                            </div>
                                        </div>
                                        <p>{!! nl2br(htmlentities($child_comment->body)) !!}</p>

                                    </div>
                                </li>
                            @endforeach

                        </ol>
                    @endif

                </li>
            @endforeach

        </ol>
    @else
        <ol class="comment-list">
            @isset($message)
                <p class="p-2">{{ $message }}</p>
            @else
                <p class="p-2"> {{ trans('front::messages.posts.there-article') }}</p>
            @endisset
        </ol>
    @endif

</div>
