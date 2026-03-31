@extends('front::layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ theme_asset('mapp/css/mapp.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('mapp/css/fa/style.css') }}">
@endpush

@push('meta')

@if(option('allow_indexing_contact') == "off" )
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="bingbot" content="noindex, nofollow">

@else
    <meta name="robots" content="index, follow"/>
    <meta name="googlebot" content="index, follow">
    <meta name="bingbot" content="index, follow">
@endif
<link rel="canonical" href="{{ route('front.contact.index') }}" />
@endpush

@section('content')

    <!-- Start main-content -->
    <main class="main-content dt-sl mt-4 mb-3">
        <div class="container main-container">

            <div class="row">
                <div class="col-12">
                    <div class="page dt-sl dt-sn pt-3 pb-5">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-ui additional-info dt-sl">
                                    <form id="contact-form" action="{{ route('front.contact.store') }}" method="POST">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-row-title">
                                                    <h3>{{ trans('front::messages.contact-us.fname-and-lname') }}</h3>
                                                </div>
                                                <div class="form-row form-group">
                                                    <input type="text" class="input-ui pr-2" name="name">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-4">
                                                <div class="form-row-title">
                                                    <h3>شماره تماس</h3>
                                                </div>
                                                <div class="form-row form-group">
                                                    <input type="mobile" class="input-ui pl-2 text-left dir-ltr" name="mobile">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-4">
                                                <div class="form-row-title">
                                                    <h3>{{ trans('front::messages.contact-us.topic') }}</h3>
                                                </div>
                                                <div class="form-row form-group">
                                                    <input type="text" class="input-ui pl-2"  name="subject">
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mt-4">
                                                <div class="form-row-title">
                                                    <h4>
                                                      {{ trans('front::messages.contact-us.message-text') }}

                                                    </h4>
                                                </div>
                                                <div class="form-row form-group">
                                                    <textarea rows="10" name="message" class="input-ui pr-2 text-right"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row mt-4">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="text" class="input-ui pl-2 captcha" autocomplete="off" name="captcha" placeholder="{{ trans('front::messages.contact-us.security-code') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <img class="captcha" src="{{ captcha_src('flat') }}" alt="captcha">
                                            </div>
                                        </div>

                                        <div class="form-row mt-3 justify-content-center">
                                            <button id="submit-btn" type="submit" class="btn-primary-cm btn-with-icon ml-2">
                                                <i class="mdi mdi-message"></i>
                                                 {{ trans('front::messages.contact-us.send-message') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div id="map"></div>
                            </div>
                        </div>
                        <div class="row row-deck">
                            <div class="col-md-4">
                                <div class="contact_tile block">
                                    <span class="tiles__icon icon-location-pin"></span>
                                    <h6 class="tiles__title">{{ trans('front::messages.contact-us.address') }}</h6>
                                    <div class="tiles__content">
                                        <p>{{ option('info_address') }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end /.col-md-4 -->

                            <div class="col-md-4">
                                <div class="contact_tile block">
                                    <span class="tiles__icon icon-earphones"></span>
                                    <h6 class="tiles__title">{{ trans('front::messages.contact-us.phone-number') }}</h6>
                                    <div class="tiles__content">
                                        <p>{{ option('info_tel') }}</p>
                                    </div>
                                </div>
                                <!-- end /.contact_tile block -->
                            </div>
                            <!-- end /.col-md-4 -->

                            <div class="col-md-4">
                                <div class="contact_tile block">
                                    <span class="tiles__icon icon-envelope-open"></span>
                                    <h6 class="tiles__title">{{ trans('front::messages.contact-us.email-address') }}</h6>
                                    <div class="tiles__content">
                                        <p>{{ option('info_email') }}</p>
                                    </div>
                                </div>
                                <!-- end /.contact_tile -->
                            </div>
                            <!-- end /.col-md-4 -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <!-- End main-content -->

    <!-- end /.map -->

    <!--================================
        END BREADCRUMB AREA
    =================================-->

@endsection

@push('scripts')
    <script src="{{ theme_asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ theme_asset('js/plugins/jquery-validation/localization/messages_fa.min.js') }}?v=2"></script>

    <script type="text/javascript" src="{{ theme_asset('mapp/js/mapp.env.js') }}"></script>
    <script type="text/javascript" src="{{ theme_asset('mapp/js/mapp.min.js?v=1') }}"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDdbCAXvJIl7CKZwfpTswAIHvqJmZTUPwQ"></script>

    <script>
        var info_map_type = "{{ option('info_map_type', 'google') }}"
        var info_latitude = "{{ option('info_latitude', '38.07709880960678') }}";
        var info_Longitude = "{{ option('info_Longitude', '46.28582686185837') }}";
        var info_site_title = "{{ option('info_site_title', 'لاراول شاپ') }}";

        var mapIrApiKey = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjYwMTBjYWE1OWU4ZDAyYzM0YWI2MGFhZDE5MTBhNjM5ZTZkYTI0MzA1ZmMwNzQzY2NmMjRkZmQ2Y2FlMzFjOThmODg4MjExYWY4ZDkwMGE1In0.eyJhdWQiOiIxMjcxOSIsImp0aSI6IjYwMTBjYWE1OWU4ZDAyYzM0YWI2MGFhZDE5MTBhNjM5ZTZkYTI0MzA1ZmMwNzQzY2NmMjRkZmQ2Y2FlMzFjOThmODg4MjExYWY4ZDkwMGE1IiwiaWF0IjoxNjEyODY3Mjc2LCJuYmYiOjE2MTI4NjcyNzYsImV4cCI6MTYxNTM3Mjg3Niwic3ViIjoiIiwic2NvcGVzIjpbImJhc2ljIl19.QNujb2BIyM8mIMy2AhivkMTpVCRyanpUIifJguxoEe4hXB1MESD2CWnO0WPq854Bi6yQyfD2w-oqjOi5N1aZmX4prggmrYelHy_mC1JEwAhWien_6QviFAvkhGDC-aPW4zjFKG2REUkQzXaeL2em543P6-hWdjFaUVSibm1XL4_CUnjJiafQsMQ67ZJ5E7Cpk92L89nJ0LMaBocex56tRqz7_7wZQUAtDYjfal90h2XaGh3QZ2rMwl69ZfMTrOEeTM9O6YCynT3IoTpDnNSXExJeMDuGv4zCD37UYG1gpVtNfipwgvc2J_LzLMXS4rnVAV2ednLKEYu7-jUXr68psg';
    </script>

    <script src="{{ theme_asset('js/pages/contact.js') }}?v=3"></script>
@endpush
