@extends('back.layouts.master')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb no-border">
                                    <li class="breadcrumb-item">مدیریت
                                    </li>
                                    <li class="breadcrumb-item">تنظیمات
                                    </li>
                                    <li class="breadcrumb-item active">درگاه های پرداخت
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- users edit start -->
                <section class="users-edit">
                    <div class="card">
                        <div id="main-card" class="card-content">
                            <div class="card-body">
                                <div class="tab-content">
                                    <form id="gateway-form" action="{{ route('admin.settings.gateways') }}" method="POST">

                                        @php
                                            $gateway = $gateways->where('key', 'payir')->first();
                                        @endphp

                                        @if ($gateway)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <fieldset class="checkbox">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input data-class="payir" type="checkbox" name="gateways[{{ $gateway->id }}][is_active]" {{ $gateway->is_active ? 'checked' : '' }}>
                                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                            <span class="">درگاه pay.ir</span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>ترتیب نمایش</label>
                                                    <div class="input-group mb-75">
                                                        <input type="number" name="gateways[{{ $gateway->id }}][ordering]" class="form-control ltr payir" value="{{ $gateway->ordering }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>عنوان</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][name]" class="form-control payir" value="{{ $gateway->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>api کد</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][merchantId]" class="form-control ltr payir" value="{{ $gateway->config('merchantId') }}" required>
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>
                                        @endif

                                        @php
                                            $gateway = $gateways->where('key', 'behpardakht')->first();
                                        @endphp

                                        @if ($gateway)
                                            <div class="row">

                                                <div class="form-group col-md-12">
                                                    <fieldset class="checkbox">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input data-class="behpardakht" type="checkbox" name="gateways[{{ $gateway->id }}][is_active]" {{ $gateway->is_active ? 'checked' : '' }}>
                                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                            <span class="">درگاه بانک ملت</span>
                                                        </div>
                                                    </fieldset>
                                                </div>

                                                <div class="col-md-2 form-group">
                                                    <label>ترتیب نمایش</label>
                                                    <div class="input-group mb-75">
                                                        <input type="number" name="gateways[{{ $gateway->id }}][ordering]" class="form-control ltr behpardakht" value="{{ $gateway->ordering }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>عنوان</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][name]" class="form-control behpardakht" value="{{ $gateway->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>نام کاربری</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][username]" class="form-control ltr behpardakht" value="{{ $gateway->config('username') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>رمز عبور</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][password]" class="form-control ltr behpardakht" value="{{ $gateway->config('password') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>کد پذیرنده</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][terminalId]" class="form-control ltr behpardakht" value="{{ $gateway->config('terminalId') }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                        @endif

                                        @php
                                            $gateway = $gateways->where('key', 'zarinpal')->first();
                                        @endphp
                                        @if ($gateway)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <fieldset class="checkbox">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input data-class="zarinpal" type="checkbox" name="gateways[{{ $gateway->id }}][is_active]" {{ $gateway->is_active ? 'checked' : '' }}>
                                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                            <span class="">درگاه زرین پال</span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>ترتیب نمایش</label>
                                                    <div class="input-group mb-75">
                                                        <input type="number" name="gateways[{{ $gateway->id }}][ordering]" class="form-control ltr zarinpal" value="{{ $gateway->ordering }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>عنوان</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][name]" class="form-control zarinpal" value="{{ $gateway->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>کد درگاه پرداخت</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][merchantId]" class="form-control ltr zarinpal" value="{{ $gateway->config('merchantId') }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                        @endif


                                        @php
                                            $gateway = $gateways->where('key', 'toman')->first();
                                        @endphp

                                        @if ($gateway)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <fieldset class="checkbox">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input data-class="toman" type="checkbox" name="gateways[{{ $gateway->id }}][is_active]" {{ $gateway->is_active ? 'checked' : '' }}>
                                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                            <span class="">درگاه تومن</span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>ترتیب نمایش</label>
                                                    <div class="input-group mb-75">
                                                        <input type="number" name="gateways[{{ $gateway->id }}][ordering]" class="form-control ltr toman" value="{{ $gateway->ordering }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>عنوان</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][name]" class="form-control toman" value="{{ $gateway->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>shop slug</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][shop_slug]" class="form-control ltr toman" value="{{ $gateway->config('shop_slug') }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 form-group">
                                                    <label>auth code</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][auth_code]" class="form-control ltr toman" value="{{ $gateway->config('auth_code') }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                        @endif


                                        @php
                                            $gateway = $gateways->where('key', 'payping')->first();
                                        @endphp
                                        @if ($gateway)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <fieldset class="checkbox">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input data-class="payping" type="checkbox" name="gateways[{{ $gateway->id }}][is_active]" {{ $gateway->is_active ? 'checked' : '' }}>
                                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                            <span class="">درگاه پی پینگ</span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>ترتیب نمایش</label>
                                                    <div class="input-group mb-75">
                                                        <input type="number" name="gateways[{{ $gateway->id }}][ordering]" class="form-control ltr payping" value="{{ $gateway->ordering }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>عنوان</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][name]" class="form-control payping" value="{{ $gateway->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>کد درگاه پرداخت</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][merchantId]" class="form-control ltr payping" value="{{ $gateway->config('merchantId') }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                        @endif

                                        @php
                                            $gateway = $gateways->where('key', 'irankish')->first();
                                        @endphp

                                        @if ($gateway)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <fieldset class="checkbox">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input data-class="irankish" type="checkbox" name="gateways[{{ $gateway->id }}][is_active]" {{ $gateway->is_active ? 'checked' : '' }}>
                                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                            <span class="">درگاه ایران کیش</span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>ترتیب نمایش</label>
                                                    <div class="input-group mb-75">
                                                        <input type="number" name="gateways[{{ $gateway->id }}][ordering]" class="form-control ltr irankish" value="{{ $gateway->ordering }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>عنوان</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][name]" class="form-control irankish" value="{{ $gateway->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>کد پایانه</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][terminalId]" class="form-control ltr irankish" value="{{ $gateway->config('terminalId') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>کد پذیرنده</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][acceptorId]" class="form-control ltr irankish" value="{{ $gateway->config('acceptorId') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>کلمه عبور</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][password]" class="form-control ltr irankish" value="{{ $gateway->config('password') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label>کلید عمومی</label>
                                                    <div class="input-group mb-75">
                                                        <textarea rows="3" name="gateways[{{ $gateway->id }}][configs][pubKey]" class="form-control ltr irankish" required>{{ $gateway->config('pubKey') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                        @endif

                                        @php
                                            $gateway = $gateways->where('key', 'pasargad')->first();
                                        @endphp

                                        @if ($gateway)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <fieldset class="checkbox">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input data-class="pasargad" type="checkbox" name="gateways[{{ $gateway->id }}][is_active]" {{ $gateway->is_active ? 'checked' : '' }}>
                                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                            <span class="">درگاه پاسارگاد</span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>ترتیب نمایش</label>
                                                    <div class="input-group mb-75">
                                                        <input type="number" name="gateways[{{ $gateway->id }}][ordering]" class="form-control ltr pasargad" value="{{ $gateway->ordering }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>عنوان</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][name]" class="form-control pasargad" value="{{ $gateway->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-md-4 form-group">
                                                            <label>merchantId</label>
                                                            <div class="input-group mb-75">
                                                                <input type="text" name="gateways[{{ $gateway->id }}][configs][merchantId]" class="form-control ltr pasargad" value="{{ $gateway->config('merchantId') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label>terminalCode</label>
                                                            <div class="input-group mb-75">
                                                                <input type="text" name="gateways[{{ $gateway->id }}][configs][terminalCode]" class="form-control ltr pasargad" value="{{ $gateway->config('terminalCode') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label>certificate</label>
                                                            <div class="input-group mb-75">
                                                                <textarea name="gateways[{{ $gateway->id }}][configs][certificate]" class="form-control ltr pasargad" rows="3" required>{{ $gateway->config('certificate') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                        @endif

                                        @php
                                            $gateway = $gateways->where('key', 'idpay')->first();
                                        @endphp

                                        @if ($gateway)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <fieldset class="checkbox">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input data-class="idpay" type="checkbox" name="gateways[{{ $gateway->id }}][is_active]" {{ $gateway->is_active ? 'checked' : '' }}>
                                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                            <span class="">درگاه idpay</span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>ترتیب نمایش</label>
                                                    <div class="input-group mb-75">
                                                        <input type="number" name="gateways[{{ $gateway->id }}][ordering]" class="form-control ltr idpay" value="{{ $gateway->ordering }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>عنوان</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][name]" class="form-control idpay" value="{{ $gateway->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>کد درگاه پرداخت</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][merchantId]" class="form-control ltr idpay" value="{{ $gateway->config('merchantId') }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                        @endif

                                        @php
                                            $gateway = $gateways->where('key', 'sepehr')->first();
                                        @endphp

                                        @if ($gateway)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <fieldset class="checkbox">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input data-class="sepehr" type="checkbox" name="gateways[{{ $gateway->id }}][is_active]" {{ $gateway->is_active ? 'checked' : '' }}>
                                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                            <span class="">درگاه سپهر (بانک صادرات) </span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>ترتیب نمایش</label>
                                                    <div class="input-group mb-75">
                                                        <input type="number" name="gateways[{{ $gateway->id }}][ordering]" class="form-control ltr sepehr" value="{{ $gateway->ordering }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>عنوان</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][name]" class="form-control sepehr" value="{{ $gateway->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>کد پذیرنده</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][terminalId]" class="form-control ltr sepehr" value="{{ $gateway->config('terminalId') }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                        @endif

                                        @php
                                            $gateway = $gateways->where('key', 'saman')->first();
                                        @endphp

                                        @if ($gateway)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <fieldset class="checkbox">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input data-class="saman" type="checkbox" name="gateways[{{ $gateway->id }}][is_active]" {{ $gateway->is_active ? 'checked' : '' }}>
                                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                            <span class="">درگاه سامان </span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>ترتیب نمایش</label>
                                                    <div class="input-group mb-75">
                                                        <input type="number" name="gateways[{{ $gateway->id }}][ordering]" class="form-control ltr saman" value="{{ $gateway->ordering }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>عنوان</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][name]" class="form-control saman" value="{{ $gateway->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>کد پذیرنده</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][merchantId]" class="form-control ltr saman" value="{{ $gateway->config('merchantId') }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                        @endif

                                        @php
                                            $gateway = $gateways->where('key', 'sadad')->first();
                                        @endphp
                                        @if ($gateway)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <fieldset class="checkbox">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input data-class="sadad" type="checkbox" name="gateways[{{ $gateway->id }}][is_active]" {{ $gateway->is_active ? 'checked' : '' }}>
                                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                            <span class="">درگاه بانک ملی </span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>ترتیب نمایش</label>
                                                    <div class="input-group mb-75">
                                                        <input type="number" name="gateways[{{ $gateway->id }}][ordering]" class="form-control ltr sadad" value="{{ $gateway->ordering }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>عنوان</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][name]" class="form-control sadad" value="{{ $gateway->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>شماره پذیرنده</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][terminalId]" class="form-control ltr sadad" value="{{ $gateway->config('terminalId') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>کد پذیرنده</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][merchantId]" class="form-control ltr sadad" value="{{ $gateway->config('merchantId') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>کلید تراکنش</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][key]" class="form-control ltr sadad" value="{{ $gateway->config('key') }}" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                        @endif

                                        @php
                                            $gateway = $gateways->where('key', 'zibal')->first();
                                        @endphp

                                        @if ($gateway)
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <fieldset class="checkbox">
                                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                                            <input data-class="zibal" type="checkbox" name="gateways[{{ $gateway->id }}][is_active]" {{ $gateway->is_active ? 'checked' : '' }}>
                                                            <span class="vs-checkbox">
                                                                <span class="vs-checkbox--check">
                                                                    <i class="vs-icon feather icon-check"></i>
                                                                </span>
                                                            </span>
                                                            <span class="">درگاه زیبال </span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <label>ترتیب نمایش</label>
                                                    <div class="input-group mb-75">
                                                        <input type="number" name="gateways[{{ $gateway->id }}][ordering]" class="form-control ltr zibal" value="{{ $gateway->ordering }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>عنوان</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][name]" class="form-control zibal" value="{{ $gateway->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>کد پذیرنده</label>
                                                    <div class="input-group mb-75">
                                                        <input type="text" name="gateways[{{ $gateway->id }}][configs][merchantId]" class="form-control ltr zibal" value="{{ $gateway->config('merchantId') }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
add

{{--                                        @php--}}
{{--                                            $gateway = $gateways->where('key', 'local')->first();--}}
{{--                                        @endphp--}}
{{--                                        @if ($gateway)--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="form-group col-md-12">--}}
{{--                                                    <fieldset class="checkbox">--}}
{{--                                                        <div class="vs-checkbox-con vs-checkbox-primary">--}}
{{--                                                            <input data-class="local" type="checkbox"--}}
{{--                                                                   name="gateways[{{ $gateway->id }}][is_active]"--}}
{{--                                                                {{ $gateway->is_active ? 'checked' : '' }}>--}}
{{--                                                            <span class="vs-checkbox">--}}
{{--                                                                <span class="vs-checkbox--check">--}}
{{--                                                                    <i class="vs-icon feather icon-check"></i>--}}
{{--                                                                </span>--}}
{{--                                                            </span>--}}
{{--                                                            <span class="">درگاه تست (Local)</span>--}}
{{--                                                        </div>--}}
{{--                                                    </fieldset>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-2 form-group">--}}
{{--                                                    <label>ترتیب نمایش</label>--}}
{{--                                                    <div class="input-group mb-75">--}}
{{--                                                        <input type="number" name="gateways[{{ $gateway->id }}][ordering]"--}}
{{--                                                               class="form-control ltr local" value="{{ $gateway->ordering }}">--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-4 form-group">--}}
{{--                                                    <label>عنوان</label>--}}
{{--                                                    <div class="input-group mb-75">--}}
{{--                                                        <input type="text" name="gateways[{{ $gateway->id }}][name]"--}}
{{--                                                               class="form-control local" value="{{ $gateway->name }}">--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <hr>--}}
{{--                                        @endif--}}




                                        <div class="row">

                                            <div class="col-12">
                                                <div class="alert alert-info mt-1 alert-validation-msg" role="alert">
                                                    <i class="feather icon-info ml-1 align-middle"></i>
                                                    <span>برای فعال نمودن هر یک از درگاه ها پس از انتخاب درگاه، اطلاعات مربوط به آن را پر کنید.</span>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                                <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">ذخیره تغییرات</button>

                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users edit ends -->

            </div>
        </div>
    </div>
@endsection

@include('back.partials.plugins', ['plugins' => ['jquery.validate']])

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/settings/gateways.js') }}?v=2"></script>
@endpush
