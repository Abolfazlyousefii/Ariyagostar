@extends('front::user.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ theme_asset('css/vendor/nice-select.css') }}">
    <script src="{{ theme_asset('js/plugins/persian-jalali-date-picker/themes/bs4.js') }}"></script>
@endpush

@section('user-content')
    <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12">
        <div class="px-3 px-res-0">
            <div class="section-title text-sm-title title-wide mb-1 no-after-title-wide dt-sl mb-2 px-res-1">
                <h2>{{ trans('front::messages.user.edit-personal-information') }}</h2>
            </div>
            <div class="form-ui additional-info dt-sl dt-sn pt-4">
                <form id="profile-form" action="{{ route('front.user.profile.update') }}" class="setting_form" method="POST">
                    @method('put')

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-row-title">
                                <h3>{{ trans('front::messages.user.name') }}</h3>
                            </div>
                            <div class="form-row form-group">
                                <input type="text" class="input-ui pr-2" placeholder="{{ trans('front::messages.user.enter-your-name') }}" name="first_name" value="{{ $user->first_name }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-row-title">
                                <h3>{{ trans('front::messages.user.fname-and-lname') }}</h3>
                            </div>
                            <div class="form-row form-group">
                                <input type="text" class="input-ui pr-2" placeholder="{{ trans('front::messages.user.enter-lname') }}" name="last_name" value="{{ $user->last_name }}">
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <div class="form-row-title">
                                <h3>{{ trans('front::messages.user.phone-number') }}</h3>
                            </div>
                            <div class="form-row form-group">
                                <input type="text" class="input-ui pl-2 text-left dir-ltr" placeholder="{{ trans('front::messages.user.enter-mobile-number') }}" name="mobile" value="{{ $user->username }}">
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <div class="form-row-title">
                                <h3>{{ trans('front::messages.user.email-address') }}</h3>
                            </div>
                            <div class="form-row form-group">
                                <input type="email" class="input-ui pl-2 text-left dir-ltr" name="email" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="col-md-6 mt-4">
                            <div class="form-row-title">
                                <h3>تاریخ تولد <small>(اختیاری)</small></h3>
                            </div>
                            <div class="form-row form-group">
                                <input tabindex="-1" data-jdp type="text" name="birthday" id="birthday" class="input-ui pr-2 ltr" {{ $user->birthday ? 'data-prev-value="1"' : '' }} value="{{ $user->birthday ? jdate($user->birthday)->format('Y/m/d') : '' }}">
                            </div>
                        </div>

                        @php
                            if($user->address) {
                                $province_id = $user->address->province_id;
                                $cities = $user->address->province->cities;
                                $city_id = $user->address->city_id;
                            } else {
                                $province_id = null;
                                $cities = [];
                                $city_id = null;
                            }
                        @endphp

                        <div class="col-lg-6 mt-4">
                            <div class="form-row-title">
                                <h3>{{ trans('front::messages.user.state') }}</h3>
                            </div>
                            <div class="form-row form-group">
                                <div class="custom-select-ui">
                                    <select class="right" name="province_id" id="province">
                                       <option value="">{{ trans('front::messages.user.select') }}</option>
                                        @foreach($provinces as $item)
                                            <option value="{{ $item->id }}" @if($item->id == $province_id) selected @endif>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-4">
                            <div class="form-row-title">
                                <h3>{{ trans('front::messages.user.city') }}</h3>
                            </div>
                            <div class="form-row form-group">
                                <div class="custom-select-ui">
                                    <select class="right" name="city_id" id="city">
                                        <option value="">{{ trans('front::messages.user.select') }}</option>
                                        @foreach($cities as $item)
                                            <option value="{{ $item->id }}" @if($item->id == $city_id) selected @endif>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-4">
                            <div class="form-row-title">
                                <h3>{{ trans('front::messages.user.postal-code') }}</h3>
                            </div>
                            <div class="form-row form-group">
                                <input type="text" class="input-ui pr-2" name="postal_code" value="{{ $user->address ? $user->address->postal_code : '' }}">
                            </div>
                        </div>
                        <div class="col-lg-6 mt-4">
                            <div class="form-row-title">
                                <h4>
                                    {{ trans('front::messages.user.postal-address') }}
                                </h4>
                            </div>
                            <div class="form-row form-group">
                                <textarea name="address" class="input-ui pr-2 text-right" placeholder="{{ trans('front::messages.user.enter-recipient-address') }}">{{ $user->address ? $user->address->address : '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="form-row mt-3 justify-content-center">
                        <button id="submit-btn" type="submit" class="btn-primary-cm btn-with-icon ml-2">
                            <i class="mdi mdi-account-circle-outline"></i>
                            {{ trans('front::messages.user.save-changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ theme_asset('js/vendor/jquery.nice-select.min.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/jquery-validation/localization/messages_fa.min.js') }}?v=2"></script>

    <script src="{{ theme_asset('js/plugins/persian-jalali-date-picker/jalali-moment.browser.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/persian-jalali-date-picker/jalali-datepicker.min.js') }}"></script>

    <script src="{{ theme_asset('js/pages/edit-profile.js') }}?v=3"></script>
@endpush
