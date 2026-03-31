<div class="sms-panel-fields" id="kavenegar-sms-fields" style="{!! option('sms_panel_provider', 'kavenegar') != 'kavenegar' ? 'display: none;' : '' !!}">
    <h5 class="my-2">اطلاعات پنل پیامک کاوه نگار</h5>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <label>کلید وب سرویس</label>
            <div class="input-group mb-75">
                <input type="text" name="KAVENEGAR_PANEL_APIKEY" class="form-control ltr" value="{{ option('KAVENEGAR_PANEL_APIKEY') }}">
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>الگوی خوش آمدگویی</label>
                    <div class="input-group mb-75">
                        <input type="text" name="user_register_pattern_code_kavenegar" class="form-control ltr sms_on_user_register" value="{{ option('user_register_pattern_code_kavenegar') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control sms_on_user_register" rows="4">%token20 عزیز خوش آمدید با شماره موبایل %token.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>الگوی ارسال کد تایید</label>
                    <div class="input-group mb-75">
                        <input type="text" name="user_verify_pattern_code_kavenegar" class="form-control ltr" value="{{ option('user_verify_pattern_code_kavenegar') }}" >
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control" rows="4">کد تایید: %token &#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>الگوی پرداخت سفارش</label>
                    <div class="input-group mb-75">
                        <input type="text" name="order_paid_pattern_code_kavenegar" class="form-control ltr sms_on_order_paid" value="{{ option('order_paid_pattern_code_kavenegar') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control sms_on_order_paid" rows="4">سفارش جدید با شماره سفارش %token ثبت و پرداخت شد.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد پترن جزئیات سفارش</label>
                    <div class="input-group mb-75">
                        <input type="text" name="order_detail_pattern_code_kavenegar" class="form-control ltr detail_sms_on_order_paid" value="{{ option('order_detail_pattern_code_kavenegar') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control detail_sms_on_order_paid" rows="4">سفارش جدید با شماره سفارش %token ثبت شد.&#13;&#10 آیتم های انتخابی: &#13;&#10 %token20 &#13;&#10 مبلغ فاکتور %token2 تومان &#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد پترن پیگیری سفارش</label>
                    <div class="input-group mb-75">
                        <input type="text" name="tracking_code_pattern_code_kavenegar" class="form-control ltr tracking_code_sms" value="{{ option('tracking_code_pattern_code_kavenegar') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control tracking_code_sms" rows="4">کد پیگیری %token20 برای سفارش شماره %token با موفقیت ثبت شد.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>الگوی پرداخت سفارش برای کاربر</label>
                    <div class="input-group mb-75">
                        <input type="text" name="user_order_paid_pattern_code_kavenegar" class="form-control ltr user_sms_on_order_paid" value="{{ option('user_order_paid_pattern_code_kavenegar') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control user_sms_on_order_paid" rows="4">سفارش شما با شماره سفارش %token با موفقیت ثبت شد.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن سفارش حضوری</label>
                    <div class="input-group mb-75">
                        <input type="text" name="in_person_order_pattern_code_kavenegar" class="form-control ltr user_sms_on_in_person_order" value="{{ option('in_person_order_pattern_code_kavenegar') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control user_sms_on_in_person_order" rows="4">%token20 عزیز&#13;&#10 با سپاس از خرید شما، شماره فاکتور: %token &#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن افزایش موجودی کیف پول</label>
                    <div class="input-group mb-75">
                        <input type="text" name="wallet_increase_pattern_code_kavenegar" class="form-control ltr wallet_increase_sms" value="{{ option('wallet_increase_pattern_code_kavenegar') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control wallet_increase_sms" rows="4">مبلغ %token تومان به اعتبار کیف پول شما اضافه شد.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن کاهش موجودی کیف پول</label>
                    <div class="input-group mb-75">
                        <input type="text" name="wallet_decrease_pattern_code_kavenegar" class="form-control ltr wallet_decrease_sms" value="{{ option('wallet_decrease_pattern_code_kavenegar') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control wallet_decrease_sms" rows="4">مبلغ %token تومان از اعتبار کیف پول شما کسر شد.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن ارسال پیامک اطلاع‌رسانی موجود شدن کالا</label>
                    <div class="input-group mb-75">
                        <input type="text" name="stock_amount_pattern_code_kavenegar" class="form-control ltr stock-amount-increased" value="{{ option('stock_amount_pattern_code_kavenegar') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control stock-amount-increased" rows="4">کد محصول token% - token20% در{{ option('info_site_title') }} موجود شد
                    </textarea>
                </div>
            </div>
        </div>
    </div>
</div>
