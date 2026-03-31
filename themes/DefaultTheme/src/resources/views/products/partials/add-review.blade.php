<!-- Modal -->
<div class="modal fade" data-action="{{ route('front.reviews.show', ['product' => $product]) }}" id="add-product-review-modal" tabindex="-1" aria-labelledby="add-product-review-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <h5 class="modal-title" id="price-changes-modal-label">{{ trans('front::messages.reviews.submit-comment-title') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ $product->title }}</p>
                <hr>
                <div class="row comments-add-col--content">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-ui">
                            <form id="add-product-review-form" action="{{ route('front.reviews.store') }}" class="px-2" method="post">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-row-title mb-2">{{ trans('front::messages.reviews.rate') }} <span class="text-danger">*</span> (<span id="selected-rating-text">{{ trans('front::messages.reviews.rate') }}</span>)</div>
                                        <div class="product-review-rate">

                                            <input data-title="{{ trans('front::messages.reviews.review-angry') }}" type="radio" id="review-angry" name="rating" value="1">
                                            <div title="{{ trans('front::messages.reviews.review-angry') }}" class="review-rate-item">
                                                <label for="review-angry">
                                                    <i class="mdi mdi-emoticon-sad-outline"></i>
                                                </label>
                                            </div>

                                            <input data-title="{{ trans('front::messages.reviews.review-sad') }}" type="radio" id="review-sad" name="rating" value="2">
                                            <div title="{{ trans('front::messages.reviews.review-sad') }}" class="review-rate-item">
                                                <label for="review-sad">
                                                    <i class="mdi mdi-emoticon-neutral-outline"></i>
                                                </label>
                                            </div>

                                            <input data-title="{{ trans('front::messages.reviews.review-neutral') }}" type="radio" id="review-neutral" name="rating" value="3">
                                            <div title="{{ trans('front::messages.reviews.review-neutral') }}" class="review-rate-item">
                                                <label for="review-neutral">
                                                    <i class="mdi mdi-emoticon-happy-outline"></i>
                                                </label>
                                            </div>

                                            <input data-title="{{ trans('front::messages.reviews.review-emoticon') }}" type="radio" id="review-emoticon" name="rating" value="4">
                                            <div title="{{ trans('front::messages.reviews.review-emoticon') }}" class="review-rate-item">
                                                <label for="review-emoticon">
                                                    <i class="mdi mdi-emoticon-outline"></i>
                                                </label>
                                            </div>

                                            <input data-title="{{ trans('front::messages.reviews.review-excited') }}" type="radio" id="review-excited" name="rating" value="5">
                                            <div title="{{ trans('front::messages.reviews.review-excited') }}" class="review-rate-item">
                                                <label for="review-excited">
                                                    <i class="mdi mdi-emoticon-excited-outline"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-row-title mb-2">{{ trans('front::messages.reviews.title') }} <span class="text-danger">*</span></div>
                                        <div class="form-row">
                                            <input class="input-ui pr-2" name="title" type="text" placeholder="{{ trans('front::messages.reviews.title-placeholder') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12 form-comment-title--positive mt-2">
                                        <div class="form-row-title mb-2 pr-2">
                                            {{ trans('front::messages.reviews.advantages') }}
                                        </div>
                                        <div id="advantages" class="form-row">
                                            <div class="ui-input--add-point">
                                                <input class="input-ui pr-2 ui-input-field" type="text" id="advantage-input" autocomplete="off" value="">
                                                <button class="ui-input-point js-icon-form-add" type="button"></button>
                                            </div>
                                            <div class="form-comment-dynamic-labels js-advantages-list"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 form-comment-title--negative mt-2">
                                        <div class="form-row-title mb-2 pr-2">
                                            {{ trans('front::messages.reviews.disadvantages') }}
                                        </div>
                                        <div id="disadvantages" class="form-row">
                                            <div class="ui-input--add-point">
                                                <input class="input-ui pr-2 ui-input-field" type="text" id="disadvantage-input" autocomplete="off" value="">
                                                <button class="ui-input-point js-icon-form-add" type="button"></button>
                                            </div>
                                            <div class="form-comment-dynamic-labels js-disadvantages-list"></div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <div class="form-row-title mb-2">{{ trans('front::messages.reviews.body') }} <span class="text-danger">*</span></div>
                                        <div class="form-row">
                                            <textarea name="body" class="input-ui pr-2 pt-2" rows="5" placeholder="{{ trans('front::messages.reviews.body-placeholder') }}" required></textarea>
                                        </div>
                                    </div>

                                    @if (auth()->user()->hasBoughtProduct($product))
                                        <div class="col-12 mt-3">
                                            <div class="product-offer-question">
                                                <div class="form-row-title mb-2">{{ trans('front::messages.reviews.suggest-text') }}</div>
                                                <div class="product-review-suggest">

                                                    <input type="radio" id="review-suggest-yes" name="suggest" value="yes">
                                                    <div class="review-suggest-item">
                                                        <label for="review-suggest-yes">
                                                            <i class="mdi mdi-thumb-up-outline"></i>
                                                            <p>{{ trans('front::messages.reviews.i-sugest') }}</p>
                                                        </label>
                                                    </div>

                                                    <input type="radio" id="review-suggest-not-sure" name="suggest" value="not_sure">
                                                    <div class="review-suggest-item">
                                                        <label for="review-suggest-not-sure">
                                                            <i class="mdi mdi-help"></i>
                                                            <p>{{ trans('front::messages.reviews.not-sure') }}</p>
                                                        </label>
                                                    </div>

                                                    <input type="radio" id="review-suggest-no" name="suggest" value="no">
                                                    <div class="review-suggest-item">
                                                        <label for="review-suggest-no">
                                                            <i class="mdi mdi-thumb-down-outline"></i>
                                                            <p>{{ trans('front::messages.reviews.i-dont-suggest') }}</p>
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-12 mt-2">
                                        <button class="btn btn btn-primary btn-block px-3">
                                            {{ trans('front::messages.reviews.submit-comment-btn') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        @if (option('dt_product_reviews_description'))
                            {!! option('dt_product_reviews_description') !!}
                        @else
                            <h3>دیگران را با نوشتن نظرات خود، برای انتخاب این محصول راهنمایی کنید.</h3>
                            <div class="desc-comment">
                                <p>لطفا پیش از ارسال نظر، خلاصه قوانین زیر را مطالعه کنید:</p>
                                <p>فارسی بنویسید و از کیبورد فارسی استفاده کنید. بهتر است از فضای خالی (Space)
                                    بیش‌از‌حدِ معمول، شکلک یا ایموجی استفاده نکنید و از کشیدن حروف یا کلمات با
                                    صفحه‌کلید بپرهیزید.</p>
                                <p>نظرات خود را براساس تجربه و استفاده‌ی عملی و با دقت به نکات فنی ارسال کنید؛
                                    بدون
                                    تعصب به محصول خاص، مزایا و معایب را بازگو کنید و بهتر است از ارسال نظرات
                                    چندکلمه‌‌ای خودداری کنید.</p>
                                <p>بهتر است در نظرات خود از تمرکز روی عناصر متغیر مثل قیمت، پرهیز کنید.</p>
                                <p>به کاربران و سایر اشخاص احترام بگذارید. پیام‌هایی که شامل محتوای توهین‌آمیز و
                                    کلمات نامناسب باشند، حذف می‌شوند.</p>
                                <p>از ارسال لینک‌های سایت‌های دیگر و ارایه‌ی اطلاعات شخصی خودتان مثل شماره تماس،
                                    ایمیل و آی‌دی شبکه‌های اجتماعی پرهیز کنید.</p>
                                <p>با توجه به ساختار بخش نظرات، از پرسیدن سوال یا درخواست راهنمایی در این بخش
                                    خودداری کرده و سوالات خود را در بخش «پرسش و پاسخ» مطرح کنید.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
