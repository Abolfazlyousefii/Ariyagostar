<div class="sms-panel-fields" id="ippannel-sms-fields" style="{!! option('sms_panel_provider', 'ippanel') != 'ippanel' ? 'display: none;' : '' !!}">
    <div class="row">
        <div class="col-md-6">
            <h5>اطلاعات پنل پیامک ippanel</h5>
        </div>
        <div class="col-md-6 text-right">
            <strong class="text-success">موجودی پنل: {{ number_format($ippanel_credit) }} ریال</strong>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <label>نام کاربری</label>
            <div class="input-group mb-75">
                <input type="text" name="SMS_PANEL_USERNAME" class="form-control ltr" value="{{ option('SMS_PANEL_USERNAME') }}">
            </div>
        </div>
        <div class="col-md-4">
            <label>رمز عبور</label>
            <div class="input-group mb-75">
                <input type="text" name="SMS_PANEL_PASSWORD" class="form-control ltr" value="{{ option('SMS_PANEL_PASSWORD') }}">
            </div>
        </div>
        <div class="col-md-4">
            <label>شماره ارسالی</label>
            <div class="input-group mb-75">
                <input type="text" name="SMS_PANEL_FROM" class="form-control ltr" value="{{ option('SMS_PANEL_FROM') }}">
            </div>
        </div>
    </div>

    <hr>

    <div class="row">

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد پترن خوش آمدگویی</label>
                    <div class="input-group mb-75">
                        <input type="text" name="user_register_pattern_code" class="form-control ltr sms_on_user_register" value="{{ option('user_register_pattern_code') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control sms_on_user_register" rows="4">%fullname% عزیز خوش آمدید.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد پترن ارسال کد تایید</label>
                    <div class="input-group mb-75">
                        <input type="text" name="user_verify_pattern_code" class="form-control ltr" value="{{ option('user_verify_pattern_code') }}" >
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control" rows="4">کد تایید: %code% &#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد پترن پرداخت سفارش</label>
                    <div class="input-group mb-75">
                        <input type="text" name="order_paid_pattern_code" class="form-control ltr sms_on_order_paid" value="{{ option('order_paid_pattern_code') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control sms_on_order_paid" rows="4">سفارش جدید با شماره سفارش %order_id% ثبت و پرداخت شد.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد پترن جزئیات سفارش</label>
                    <div class="input-group mb-75">
                        <input type="text" name="order_detail_pattern_code" class="form-control ltr detail_sms_on_order_paid" value="{{ option('order_detail_pattern_code') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control detail_sms_on_order_paid" rows="4">سفارش جدید با شماره سفارش %order_id% ثبت شد.&#13;&#10 آیتم های انتخابی: &#13;&#10 %items% &#13;&#10 مبلغ فاکتور %order_price% تومان &#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد پترن پیگیری سفارش</label>
                    <div class="input-group mb-75">
                        <input type="text" name="tracking_code_pattern_code" class="form-control ltr tracking_code_sms" value="{{ option('tracking_code_pattern_code') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control tracking_code_sms" rows="4">کد پیگیری %tracking_code% برای سفارش شماره %order_id% با موفقیت ثبت شد.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد پترن پرداخت سفارش برای کاربر</label>
                    <div class="input-group mb-75">
                        <input type="text" name="user_order_paid_pattern_code" class="form-control ltr user_sms_on_order_paid" value="{{ option('user_order_paid_pattern_code') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control user_sms_on_order_paid" rows="4">سفارش شما با شماره سفارش %order_id% با موفقیت ثبت شد.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن سفارش حضوری</label>
                    <div class="input-group mb-75">
                        <input type="text" name="in_person_order_pattern_code" class="form-control ltr user_sms_on_in_person_order" value="{{ option('in_person_order_pattern_code') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control user_sms_on_in_person_order" rows="4">%fullname% عزیز &#13;&#10 با سپاس از خرید شما &#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن افزایش موجودی کیف پول</label>
                    <div class="input-group mb-75">
                        <input type="text" name="wallet_increase_pattern_code_ippanel" class="form-control ltr wallet_increase_sms" value="{{ option('wallet_increase_pattern_code_ippanel') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control wallet_increase_sms" rows="4">مبلغ %amount% تومان به اعتبار کیف پول شما اضافه شد.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن کاهش موجودی کیف پول</label>
                    <div class="input-group mb-75">
                        <input type="text" name="wallet_decrease_pattern_code_ippanel" class="form-control ltr wallet_decrease_sms" value="{{ option('wallet_decrease_pattern_code_ippanel') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control wallet_decrease_sms" rows="4">مبلغ %amount% تومان از اعتبار کیف پول شما کسر شد.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن ارسال پیامک اطلاع‌رسانی موجود شدن کالا</label>
                    <div class="input-group mb-75">
                        <input type="text" name="stock_amount_pattern_code_ippanel" class="form-control ltr stock-amount-increased" value="{{ option('stock_amount_pattern_code_ippanel') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control stock-amount-increased" rows="4">%product_title% در {{ option('info_site_title') }} موجود شد</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
