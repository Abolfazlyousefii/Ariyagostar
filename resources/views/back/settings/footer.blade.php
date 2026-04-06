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
                                    <li class="breadcrumb-item">مدیریت</li>
                                    <li class="breadcrumb-item">تنظیمات</li>
                                    <li class="breadcrumb-item active">مدیریت فوتر</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section class="users-edit">
                    <div class="card">
                        <div id="footer-main-card" class="card-content">
                            <div class="card-body">
                                <form id="footer-form" action="{{ route('admin.settings.footer') }}" method="POST" enctype="multipart/form-data">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h4 class="mb-0">ویرایش بخش‌بندی فوتر</h4>
                                        <button type="button" id="reset-footer" data-action="{{ route('admin.settings.footer.reset') }}" class="btn btn-outline-danger">بازنشانی پیش‌فرض</button>
                                    </div>

                                    <div class="alert alert-light-info mb-2">
                                        این صفحه برای مدیریت فوتر بدون کدنویسی طراحی شده است. بخش‌ها و آیتم‌ها را اضافه/حذف/مرتب/فعال یا غیرفعال کنید.
                                    </div>

                                    <div class="card border mb-2">
                                        <div class="card-header"><h5 class="card-title mb-0">ترتیب و وضعیت بخش‌ها</h5></div>
                                        <div class="card-body">
                                            <div id="sections-wrapper"></div>
                                            <button type="button" class="btn btn-sm btn-outline-primary mt-1" id="add-section">افزودن بخش</button>
                                            <small class="d-block text-muted mt-1">نوع‌های پیشنهادی: دسترسی سریع، معرفی شرکت، تماس و شبکه اجتماعی، نماد اعتماد</small>
                                        </div>
                                    </div>

                                    <div class="card border mb-2">
                                        <div class="card-header"><h5 class="card-title mb-0">بخش دسترسی سریع (حداکثر ۴ لینک)</h5></div>
                                        <div class="card-body">
                                            <div id="quick-links-wrapper"></div>
                                            <button type="button" class="btn btn-sm btn-outline-primary mt-1" id="add-quick-link">افزودن لینک</button>
                                        </div>
                                    </div>

                                    <div class="card border mb-2">
                                        <div class="card-header"><h5 class="card-title mb-0">بخش معرفی کوتاه شرکت</h5></div>
                                        <div class="card-body">
                                            <fieldset class="form-group">
                                                <label>متن معرفی کوتاه</label>
                                                <textarea class="form-control" name="footer_company_description" rows="4">{{ $company_description }}</textarea>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="card border mb-2">
                                        <div class="card-header"><h5 class="card-title mb-0">بخش تماس و شبکه‌های اجتماعی</h5></div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label>آدرس</label>
                                                    <textarea class="form-control" name="contact_address" rows="2">{{ $contact_data['address'] ?? '' }}</textarea>
                                                    <div class="custom-control custom-switch mt-1">
                                                        <input type="checkbox" class="custom-control-input" id="contact_show_address" name="contact_show_address" value="1" {{ !empty($contact_data['show_address']) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="contact_show_address">نمایش آدرس</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>تلفن</label>
                                                    <input type="text" class="form-control" name="contact_phone" value="{{ $contact_data['phone'] ?? '' }}">
                                                    <div class="custom-control custom-switch mt-1">
                                                        <input type="checkbox" class="custom-control-input" id="contact_show_phone" name="contact_show_phone" value="1" {{ !empty($contact_data['show_phone']) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="contact_show_phone">نمایش تلفن</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>ایمیل</label>
                                                    <input type="email" class="form-control" name="contact_email" value="{{ $contact_data['email'] ?? '' }}">
                                                    <div class="custom-control custom-switch mt-1">
                                                        <input type="checkbox" class="custom-control-input" id="contact_show_email" name="contact_show_email" value="1" {{ !empty($contact_data['show_email']) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="contact_show_email">نمایش ایمیل</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label>لینک اینستاگرام</label>
                                                    <input type="url" class="form-control ltr" name="contact_instagram" value="{{ $contact_data['instagram'] ?? '' }}">
                                                    <div class="custom-control custom-switch mt-1">
                                                        <input type="checkbox" class="custom-control-input" id="contact_show_instagram" name="contact_show_instagram" value="1" {{ !empty($contact_data['show_instagram']) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="contact_show_instagram">نمایش اینستاگرام</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>لینک تلگرام</label>
                                                    <input type="url" class="form-control ltr" name="contact_telegram" value="{{ $contact_data['telegram'] ?? '' }}">
                                                    <div class="custom-control custom-switch mt-1">
                                                        <input type="checkbox" class="custom-control-input" id="contact_show_telegram" name="contact_show_telegram" value="1" {{ !empty($contact_data['show_telegram']) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="contact_show_telegram">نمایش تلگرام</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>لینک واتساپ</label>
                                                    <input type="url" class="form-control ltr" name="contact_whatsapp" value="{{ $contact_data['whatsapp'] ?? '' }}">
                                                    <div class="custom-control custom-switch mt-1">
                                                        <input type="checkbox" class="custom-control-input" id="contact_show_whatsapp" name="contact_show_whatsapp" value="1" {{ !empty($contact_data['show_whatsapp']) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="contact_show_whatsapp">نمایش واتساپ</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label>تصویر نماد اعتماد</label>
                                                    <div class="custom-file">
                                                        <input type="file" name="contact_trust_badge_image" class="custom-file-input" accept="image/*">
                                                        <label class="custom-file-label">انتخاب تصویر</label>
                                                    </div>
                                                    @if(!empty($contact_data['trust_badge_image']))
                                                        <small class="d-block mt-1">تصویر فعلی: <a target="_blank" href="{{ asset($contact_data['trust_badge_image']) }}">مشاهده</a></small>
                                                    @endif
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label>لینک نماد اعتماد (اختیاری)</label>
                                                    <input type="url" class="form-control ltr" name="contact_trust_badge_url" value="{{ $contact_data['trust_badge_url'] ?? '' }}">
                                                    <div class="custom-control custom-switch mt-1">
                                                        <input type="checkbox" class="custom-control-input" id="contact_show_trust_badge" name="contact_show_trust_badge" value="1" {{ !empty($contact_data['show_trust_badge']) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="contact_show_trust_badge">نمایش نماد اعتماد</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1 px-0">
                                        <button type="submit" class="btn btn-primary glow">ذخیره تنظیمات فوتر</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <template id="section-row-template">
        <div class="border rounded p-1 mb-1 section-row bg-light">
            <div class="row align-items-end">
                <div class="col-md-3 form-group mb-50">
                    <label>نوع بخش</label>
                    <select class="form-control section-type">
                        <option value="quick_links">دسترسی سریع</option>
                        <option value="company_intro">معرفی کوتاه شرکت</option>
                        <option value="contact_social">تماس و شبکه‌های اجتماعی</option>
                        <option value="trust_badge">نماد اعتماد</option>
                    </select>
                </div>
                <div class="col-md-4 form-group mb-50">
                    <label>عنوان بخش</label>
                    <input type="text" class="form-control section-title" maxlength="120">
                </div>
                <div class="col-md-2 form-group mb-50">
                    <label>ترتیب</label>
                    <input type="number" min="0" class="form-control section-sort">
                </div>
                <div class="col-md-2 form-group mb-50">
                    <div class="custom-control custom-switch mt-2">
                        <input type="checkbox" class="custom-control-input section-enabled">
                        <label class="custom-control-label">فعال</label>
                    </div>
                </div>
                <div class="col-md-1 form-group mb-50 d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-outline-secondary move-up">↑</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary move-down">↓</button>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-section">×</button>
                </div>
            </div>
        </div>
    </template>

    <template id="quick-link-row-template">
        <div class="border rounded p-1 mb-1 quick-link-row bg-light">
            <div class="row align-items-end">
                <div class="col-md-3 form-group mb-50">
                    <label>عنوان لینک</label>
                    <input type="text" class="form-control quick-link-label" maxlength="120">
                </div>
                <div class="col-md-5 form-group mb-50">
                    <label>URL</label>
                    <input type="url" class="form-control quick-link-url ltr" placeholder="https://example.com">
                </div>
                <div class="col-md-2 form-group mb-50">
                    <label>ترتیب</label>
                    <input type="number" min="0" class="form-control quick-link-sort">
                </div>
                <div class="col-md-1 form-group mb-50">
                    <div class="custom-control custom-switch mt-2">
                        <input type="checkbox" class="custom-control-input quick-link-enabled">
                        <label class="custom-control-label">فعال</label>
                    </div>
                </div>
                <div class="col-md-1 form-group mb-50 d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-outline-secondary move-up">↑</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary move-down">↓</button>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-quick-link">×</button>
                </div>
            </div>
        </div>
    </template>

    <script>
        window.footerInitialData = {
            sections: @json($sections),
            quickLinks: @json($quick_links),
        };
    </script>
@endsection

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/settings/footer.js') }}?v=1"></script>
@endpush
