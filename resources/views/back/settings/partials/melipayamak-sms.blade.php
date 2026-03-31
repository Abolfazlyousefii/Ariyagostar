<div class="sms-panel-fields" id="melipayamak-sms-fields" style="{!! option('sms_panel_provider', 'melipayamak') != 'melipayamak' ? 'display: none;' : '' !!}">
    <h5 class="my-2">اطلاعات پنل ملی پیامک</h5>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <label>نام کاربری</label>
            <div class="input-group mb-75">
                <input type="text" name="MELIPAYAMAK_PANEL_USERNAME" class="form-control ltr" value="{{ option('MELIPAYAMAK_PANEL_USERNAME') }}">
            </div>
        </div>
        <div class="col-md-4">
            <label>رمز عبور</label>
            <div class="input-group mb-75">
                <input type="text" name="MELIPAYAMAK_PANEL_PASSWORD" class="form-control ltr" value="{{ option('MELIPAYAMAK_PANEL_PASSWORD') }}">
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن خوش آمدگویی</label>
                    <div class="input-group mb-75">
                        <input type="text" name="user_register_pattern_code_melipayamak" class="form-control ltr sms_on_user_register" value="{{ option('user_register_pattern_code_melipayamak') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control sms_on_user_register" rows="4">{0} عزیز خوش آمدید. &#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن ارسال کد تایید</label>
                    <div class="input-group mb-75">
                        <input type="text" name="user_verify_pattern_code_melipayamak" class="form-control ltr" value="{{ option('user_verify_pattern_code_melipayamak') }}" >
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control" rows="4">کد تایید: {0} &#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن پرداخت سفارش</label>
                    <div class="input-group mb-75">
                        <input type="text" name="order_paid_pattern_code_melipayamak" class="form-control ltr sms_on_order_paid" value="{{ option('order_paid_pattern_code_melipayamak') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control sms_on_order_paid" rows="4">سفارش جدید با شماره سفارش {0} ثبت و پرداخت شد.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد پترن جزئیات سفارش</label>
                    <div class="input-group mb-75">
                        <input type="text" name="order_detail_pattern_code_melipayamak" class="form-control ltr detail_sms_on_order_paid" value="{{ option('order_detail_pattern_code_melipayamak') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control detail_sms_on_order_paid" rows="4">سفارش جدید با شماره سفارش {0} ثبت شد.&#13;&#10 آیتم های انتخابی: &#13;&#10 {1} &#13;&#10 مبلغ فاکتور {2} تومان &#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد پترن پیگیری سفارش</label>
                    <div class="input-group mb-75">
                        <input type="text" name="tracking_code_pattern_code_melipayamak" class="form-control ltr tracking_code_sms" value="{{ option('tracking_code_pattern_code_melipayamak') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control tracking_code_sms" rows="4">کد پیگیری {0} برای سفارش شماره {1} با موفقیت ثبت شد.&#13;&#10 {{ option('info_site_title') }} </textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن پرداخت سفارش برای کاربر</label>
                    <div class="input-group mb-75">
                        <input type="text" name="user_order_paid_pattern_code_melipayamak" class="form-control ltr user_sms_on_order_paid" value="{{ option('user_order_paid_pattern_code_melipayamak') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control user_sms_on_order_paid" rows="4">سفارش شما با شماره سفارش {0} با موفقیت ثبت شد.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن سفارش حضوری</label>
                    <div class="input-group mb-75">
                        <input type="text" name="in_person_order_pattern_code_melipayamak" class="form-control ltr user_sms_on_in_person_order" value="{{ option('in_person_order_pattern_code_melipayamak') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control user_sms_on_in_person_order" rows="4">{0} عزیز &#13;&#10 با سپاس از خرید شما &#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن افزایش موجودی کیف پول</label>
                    <div class="input-group mb-75">
                        <input type="text" name="wallet_increase_pattern_code_melipayamak" class="form-control ltr wallet_increase_sms" value="{{ option('wallet_increase_pattern_code_melipayamak') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control wallet_increase_sms" rows="4">مبلغ {0} تومان به اعتبار کیف پول شما اضافه شد.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن کاهش موجودی کیف پول</label>
                    <div class="input-group mb-75">
                        <input type="text" name="wallet_decrease_pattern_code_melipayamak" class="form-control ltr wallet_decrease_sms" value="{{ option('wallet_decrease_pattern_code_melipayamak') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control wallet_decrease_sms" rows="4">مبلغ {0} تومان از اعتبار کیف پول شما کسر شد.&#13;&#10 {{ option('info_site_title') }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 form-group mb-0">
                    <label>کد متن ارسال پیامک اطلاع‌رسانی موجود شدن کالا</label>
                    <div class="input-group mb-75">
                        <input type="text" name="stock_increase_pattern_code_melipayamak" class="form-control ltr stock-amount-increased" value="{{ option('stock_increase_pattern_code_melipayamak') }}" required>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <label>متن نمونه ایجاد پترن</label>
                    <textarea readonly class="form-control stock-amount-increased" rows="4">{0} در {{ option('info_site_title') }} موجود شد</textarea>
                </div>
            </div>
        </div>



    </div>
</div>
