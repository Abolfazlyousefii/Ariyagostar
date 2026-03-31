<form id="review-edit-form" action="{{ route('admin.reviews.update', ['review' => $review]) }}">
    @method('put')

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>کاربر</label>
                <p>{{ $review->user ? $review->user->fullname : $review->name }}

                    @if ($review->user)
                        <a class="float-right" href="{{ route('admin.users.show', ['user' => $review->user]) }}" target="_blank"><i class="feather icon-external-link"></i></a>
                    @endif
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>تاریخ ارسال</label>
                <p>{{ jdate($review->created_at) }}  ( {{ jdate($review->created_at)->ago() }} )</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>عنوان</label>
                <input type="text" class="form-control" name="title" value="{{ $review->title }}" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>امتیاز</label>
                <select class="form-control" name="rating">
                    <option value="1" {{ $review->rating == '1' ? 'selected' : '' }}>خیلی بد (1)</option>
                    <option value="2" {{ $review->rating == '2' ? 'selected' : '' }}>بد (2)</option>
                    <option value="3" {{ $review->rating == '3' ? 'selected' : '' }}>معمولی (3)</option>
                    <option value="4" {{ $review->rating == '4' ? 'selected' : '' }}>خوب (4)</option>
                    <option value="5" {{ $review->rating == '5' ? 'selected' : '' }}>خیلی خوب (5)</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>وضعیت</label>
                <select class="form-control" name="status">
                    <option value="pending" {{ $review->status == 'pending' ? 'selected' : '' }}>منتظر تایید</option>
                    <option value="accepted" {{ $review->status == 'accepted' ? 'selected' : '' }}>تایید شده</option>
                    <option value="rejected" {{ $review->status == 'rejected' ? 'selected' : '' }}>تایید نشده</option>
                </select>
            </div>
        </div>

        @if ($review->suggest)
            <div class="col-md-6">
                <div class="form-group">
                    <label>پیشنهاد</label>
                    <select class="form-control" name="suggest">
                        <option value="yes" {{ $review->suggest == 'yes' ? 'selected' : '' }}>پیشنهاد می کنم</option>
                        <option value="not_sure" {{ $review->suggest == 'not_sure' ? 'selected' : '' }}>مطمئن نیستم</option>
                        <option value="no" {{ $review->suggest == 'no' ? 'selected' : '' }}>پیشنهاد نمی کنم</option>
                    </select>
                </div>
            </div>
        @endif

        <div class="col-md-12">
            <div class="form-group">
                <label>متن دیدگاه</label>
                <textarea name="body" class="form-control" rows="4" required>{{ $review->body }}</textarea>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>نقاط قوت</label>
                @if (!$review->points->where('type', 'positive')->count())
                    <p>چیزی ثبت نشده است</p>
                @endif

                @foreach ($review->points->where('type', 'positive') as $point)
                    <div class="row mb-1">
                        <div class="col-10">
                            <input type="text" name="review[advantages][]" class="form-control" value="{{ $point->text }}">
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-flat-danger waves-effect waves-light remove-review-pint custom-padding"><i class="feather icon-minus"></i></button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>نقاط ضعف</label>
                @if (!$review->points->where('type', 'negative')->count())
                    <p>چیزی ثبت نشده است</p>
                @endif

                @foreach ($review->points->where('type', 'negative') as $point)
                    <div class="row mb-1">
                        <div class="col-10">
                            <input type="text" name="review[disadvantages][]" class="form-control" value="{{ $point->text }}">
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-flat-danger waves-effect waves-light remove-review-pint custom-padding"><i class="feather icon-minus"></i></button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</form>
