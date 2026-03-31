<div class="table-responsive">
    <form id="comment-edit-form" action="{{ route('admin.comments.update', ['comment' => $comment]) }}">
        @method('put')

        <table class="table">
            <tbody>

                <tr>
                    <th scope="row">نام</th>
                    <td>
                        {{ $comment->user ? $comment->user->fullname : $comment->name }}

                        @if ($comment->user)
                            <a class="float-right" href="{{ route('admin.users.show', ['user' => $comment->user]) }}" target="_blank"><i class="feather icon-external-link"></i></a>
                        @endif
                    </td>

                </tr>
                <tr>
                    <th scope="row">در </th>
                    <td>{{ $comment->commentable->title }} <a class="float-right" href="{{ $comment->commentable->link() }}" target="_blank"><i class="feather icon-external-link"></i></a></td>

                </tr>

                <tr>
                    <th scope="row" style="min-width: 100px;">متن دیدگاه</th>
                    <td>
                        <div id="comment-body">
                            {{ $comment->body }}

                            <div class="mt-1">
                                <button id="edit-comment-btn" type="button" class="btn btn-flat-primary waves-effect waves-light"><i class="feather icon-edit"></i> ویرایش</button>
                            </div>
                        </div>


                        <fieldset id="edit-comment-body" class="form-group" style="display: none;">
                            <textarea name="body" class="form-control" rows="4" required>{{ $comment->body }}</textarea>
                        </fieldset>
                    </td>

                </tr>

                @if (!$comment->comment_id)
                    <tr>
                        <th scope="row">تعداد پاسخ ها</th>
                        <td>{{ $comment->comments->count() }}</td>

                    </tr>
                    <tr>
                        <th scope="row">پاسخ</th>
                        <td>
                            <fieldset class="form-group">
                                <textarea name="replay" class="form-control" rows="4"></textarea>
                            </fieldset>
                        </td>

                    </tr>
                @endif

                <tr>
                    <th scope="row">تاریخ ارسال</th>
                    <td>{{ jdate($comment->created_at) }}  ( {{ jdate($comment->created_at)->ago() }} )</td>
                </tr>

                <tr>
                    <th scope="row">وضعیت</th>
                    <td>
                        <select class="form-control" name="status">
                            <option value="pending" {{ $comment->status == 'pending' ? 'selected' : '' }}>منتظر تایید</option>
                            <option value="accepted" {{ $comment->status == 'accepted' ? 'selected' : '' }}>تایید شده</option>
                            <option value="unconfirmed" {{ $comment->status == 'unconfirmed' ? 'selected' : '' }}>تایید نشده</option>
                        </select>
                    </td>
                </tr>

            </tbody>
        </table>
    </form>
</div>
