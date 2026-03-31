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
                                    <li class="breadcrumb-item">توسعه دهنده
                                    </li>
                                    <li class="breadcrumb-item active">بروزرسانی
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <div class="alert alert-warning py-2" role="alert">
                    <i class="feather icon-alert-triangle mr-1 align-middle"></i>
                    <span>لطفا توجه داشته باشید در صورتی که نرم افزار را شخصی سازی کرده اید و در کدها تغییراتی ایجاد کرده اید، با بروزرسانی نرم افزار تغییرات از بین می روند.</span>
                </div>
                <section class="card">

                    <div id="main-card" class="card-content">
                        <div class="card-body">

                            <div class="col-md-12">
                                <h3>بروزرسانی نرم افزار</h3>
                                <hr>
                                <div class="alert alert-info" role="alert">
                                    <span>نسخه فعلی نرم افزار شما {{ $versionInstalled }}</span>
                                </div>

                                @if ($isNewVersionAvailable)
                                    <div class="alert alert-primary" role="alert">
                                        <i class="feather icon-check mr-1 align-middle"></i>
                                        <span>نسخه {{ $versionAvailable }} موجود است و هم اکنون میتوانید نرم افزار را بروزرسانی کنید.</span>
                                    </div>

                                    <button data-action="{{ route('admin.old.developer.updateApplication') }}" id="update-application" type="button" class="btn btn-lg btn-success mb-1 waves-effect waves-light"><i class="feather icon-refresh-ccw mr-1"></i> بروزرسانی </button>
                                @else
                                    <div class="alert alert-success" role="alert">
                                        <span>شما از آخرین نسخه ی موجود نرم افزار استفاده میکنید.</span>
                                    </div>
                                @endif

                                <button data-action="{{ route('admin.developer.updaterAfter') }}" id="updater-after" type="button" class="btn btn-lg btn-primary mb-1 waves-effect waves-light"><i class="feather icon-settings mr-1"></i> اجرای دستورات بعد از بروزرسانی </button>

                            </div>

                        </div>
                    </div>
                </section>

                <div id="form-progress" class="progress progress-bar-success progress-xl" style="display: none;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:0"></div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">تغییرات بروزرسانی ها</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <ul class="activity-timeline timeline-left list-unstyled">
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.18</p>
                                        <p class="font-small-3">- اضافه شدن ویجت صفحه سفارشی</p>
                                        <p class="font-small-3">- اضافه شدن امکان ویرایش سفارشات ثبت شده توسط مشتری</p>
                                        <p class="font-small-3">- اضافه شدن امکان غیرفعال سازی ایندکس صفحات</p>
                                        <p class="font-small-3">- ارسال پیامک زمان موجود شدن محصول به کاربران لیست (موجود شد به من اطلاع دهید)</p>
                                        <p class="font-small-3">- آپدیت لاراول به نسخه 10</p>
                                        <p class="font-small-3">- رفع برخی از باگ های جزئی</p>
                                        <p class="font-small-3">- بروزرسانی کتابخانه ها</p>
                                    </div>
                                    <small class="text-primary">15 تیر 1404</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.17</p>
                                        <p class="font-small-3">- اضافه شدن ویجت تخفیف زماندار</p>
                                        <p class="font-small-3">- اضافه شدن تخفیف دسته جمعی برای محصولات</p>
                                        <p class="font-small-3">- اضافه شدن تخفیف ارسال رایگان</p>
                                        <p class="font-small-3">- رفع برخی از باگ های جزئی</p>
                                        <p class="font-small-3">- بروزرسانی کتابخانه ها</p>
                                    </div>
                                    <small class="text-primary">17 اسفند 1403</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.16</p>
                                        <p class="font-small-3">- بهبود ویجت های صفحه اول</p>
                                        <p class="font-small-3">- اضافه شدن ویجت اسلایدر تمام صفحه</p>
                                        <p class="font-small-3">- رفع برخی از باگ های جزئی</p>
                                    </div>
                                    <small class="text-primary">10 تیر 1403</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.15</p>
                                        <p class="font-small-3">- اضافه شدن درگاه تومن</p>
                                        <p class="font-small-3">- اضافه شدن پنل اس ام اس ایده پردازان</p>
                                        <p class="font-small-3">- رفع برخی از باگ های جزئی</p>
                                    </div>
                                    <small class="text-primary">3 آیان 1402</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.14</p>
                                        <p class="font-small-3">- اضافه شدن لینک های اشتراک گذاری محصول در شبکه های اجتماعی</p>
                                        <p class="font-small-3">- امکان تغییر وضعیت ارسال سفارشات بصورت گروهی</p>
                                        <p class="font-small-3">- امکان زماندار کردن تخفیف محصولات</p>
                                        <p class="font-small-3">- امکان زماندار کردن محصولات ویژه</p>
                                        <p class="font-small-3">- امکان رزرو سفارش و ارسال آن همراه با سفارشات بعدی</p>
                                        <p class="font-small-3">- امکان اضافه کردن پاپ آپ متنی یا تصویری به صفحه اصلی فروشگاه</p>
                                        <p class="font-small-3">- رفع برخی از باگ های جزئی</p>
                                    </div>
                                    <small class="text-primary">6 فروردین 1402</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.13</p>
                                        <p class="font-small-3">- اضافه شدن بخش نظرات پیشرفته برای محصولات</p>
                                        <p class="font-small-3">- ایجاد ساختار کلی برای سایت چند زبانه (کامل نشده)</p>
                                        <p class="font-small-3">- بهبود ظاهری صفحه محصول</p>
                                        <p class="font-small-3">- امکان ثبت خودکار کد تخفیف با معرفی افراد</p>
                                        <p class="font-small-3">- اضافه شدن بخش راهنمای سایزبندی برای محصولات</p>
                                        <p class="font-small-3">- امکان چاپ گروهی فاکتورها و برچسب های پستی</p>
                                        <p class="font-small-3">- رفع برخی از باگ های جزئی</p>
                                    </div>
                                    <small class="text-primary">9 مرداد 1401</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.12</p>
                                        <p class="font-small-3">- اضافه شدن پنل پیامک کاوه نگار</p>
                                        <p class="font-small-3">- امکان خروجی گرفتن از لیست محصولات و لیست سفارشات به صورت پیشرفته</p>
                                        <p class="font-small-3">- اضافه شدن فیلم آموزش ایجاد محصول</p>
                                        <p class="font-small-3">- اضافه شدن ملی پیامک</p>
                                        <p class="font-small-3">- اطلاع رسانی افزایش و کاهش کیف پول با پیامک</p>
                                        <p class="font-small-3">- امکان تعیین شارژ هدیه برای ثبت نام کاربران</p>
                                        <p class="font-small-3">- اضافه شدن صفحه برندها</p>
                                        <p class="font-small-3">- رفع برخی از باگ های جزئی</p>
                                    </div>
                                    <small class="text-primary">6 اردیبهشت 1401</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.11</p>
                                        <p class="font-small-3">- اضافه شدن برخی از وب سرویس ها برای استفاده دراپلیکیشن اندروید</p>
                                        <p class="font-small-3">- اضافه شدن امکان برچسب گذاری محصولات</p>
                                        <p class="font-small-3">- اضافه شدن ابزارک نوشته های وبلاگ در صفحه اصلی</p>
                                        <p class="font-small-3">- بهبود ظاهری برخی از قسمت ها</p>
                                        <p class="font-small-3">- امکان اضافه کردن به سبد خرید از صفحه اصلی برای محصولات تک قیمته</p>
                                        <p class="font-small-3">- بهبود فاکتور سفارش و چاپ برچسب پستی</p>
                                        <p class="font-small-3">- امکان پیش نویس کردن دسته بندی ها</p>
                                        <p class="font-small-3">- امکان ورود با رمز یکبار مصرف</p>
                                        <p class="font-small-3">- نمایش لیست همه تراکنش های کیف پول</p>
                                        <p class="font-small-3">- اضافه شدن درگاه بانک ملی</p>
                                        <p class="font-small-3">- اضافه شدن درگاه زیبال</p>
                                        <p class="font-small-3">- رفع برخی از باگ های جزئی</p>
                                    </div>
                                    <small class="text-primary">30 دی 1400</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.10</p>
                                        <p class="font-small-3">- اضافه شدن قسمت ارزها و فروش محصول بر اساس نرخ ارز مثل (دلار، یورو و....)</p>
                                        <p class="font-small-3">- اضافه شدن بخش  روش های ارسال، و امکان  تعریف بی نهایت روش ارسال با امکانات پشرفته</p>
                                        <p class="font-small-3">- رفع برخی از باگ ها</p>
                                    </div>
                                    <small class="text-primary">30 آبان 1400</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.9</p>
                                        <p class="font-small-3">- اضافه شدن کیف پول و امکان شارژ و پرداخت با کیف پول</p>
                                        <p class="font-small-3">- اضافه شدن گزارشات آماری سفارشات</p>
                                        <p class="font-small-3">- اضافه شدن گزارشات آماری کاربران</p>
                                        <p class="font-small-3">- اضافه شدن گزارشات آماری بازدیدها</p>
                                        <p class="font-small-3">- انتخاب رنگ بندی قالب از بخش تنظیمات قالب</p>
                                        <p class="font-small-3">- مرتب سازی محصولات براساس  جدیدترین، پربازدیدترین،  پرفروش ترین، ارزان ترین و گران ترین در صفحه دسته بندی</p>
                                        <p class="font-small-3">- رفع برخی از باگ ها</p>
                                    </div>
                                    <small class="text-primary">09 آبان 1400</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.8</p>
                                        <p class="font-small-3">- امکان مدیریت چیدمان صفحه اصلی فروشگاه</p>
                                        <p class="font-small-3">- بهبود ظاهری برخی از  صفحات</p>
                                        <p class="font-small-3">- اضافه شدن نمودار قیمت برای محصولات</p>
                                        <p class="font-small-3">- تفکیک کردن لیست سفارشات</p>
                                        <p class="font-small-3">- اضافه کردن درگاه idpay</p>
                                        <p class="font-small-3">- بهبود ظاهری صفحه سبد خرید</p>
                                        <p class="font-small-3">- رفع برخی از باگ ها</p>
                                    </div>
                                    <small class="text-primary">20 مهر 1400</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.7</p>
                                        <p class="font-small-3">- کش کردن اطلاعات صفحه اصلی</p>
                                        <p class="font-small-3">- اضافه کردن آموزش تصویری برای برخی از صفحات</p>
                                        <p class="font-small-3">- امکان مدیریت لیست استان ها و شهر ها</p>
                                        <p class="font-small-3">- رفع برخی از باگ ها</p>
                                    </div>
                                    <small class="text-primary">14 شهریور 1400</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.6</p>
                                        <p class="font-small-3">- اضافه شدن بخش محصول دانلودی</p>
                                        <p class="font-small-3">- بهبود صفحه لیست قیمت ها</p>
                                        <p class="font-small-3">- اضافه شدن صفحه  لیست محصولات منتظر ارسال</p>
                                        <p class="font-small-3">- امکان شخصی سازی نام و ترتیب درگاه های پرداخت </p>
                                        <p class="font-small-3">- رفع باگ های جزئی</p>

                                    </div>
                                    <small class="text-primary">24 مرداد 1400</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.5</p>
                                        <p class="font-small-3">- ارسال پوش نوتیفیکیشن و پیامک به مدیر سایت هنگام پرداخت سفارش</p>
                                        <p class="font-small-3">- بهبود عملکرد کرون جاب</p>
                                        <p class="font-small-3">- رفع باگ های جزئی</p>
                                        <p class="font-small-3">- بهبود صفحه لیست سفارشات در پنل مدیریت و اضافه شدن فیلترها</p>
                                        <p class="font-small-3">- اضافه شدن درگاه بانک صادرات و پی پینگ و سامان</p>
                                        <p class="font-small-3">- اضافه شدن بخش ایجاد تخفیف به صورت پیشرفته</p>

                                    </div>
                                    <small class="text-primary">02 مرداد 1400</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.4</p>
                                        <p class="font-small-3">- اضافه شدن تایید شماره همراه کاربران با ارسال پیامک</p>
                                        <p class="font-small-3">- رفع باگ های گزارش شده توسط مشتریان</p>
                                        <p class="font-small-3">- امکان بازیابی رمز عبور با پیامک</p>
                                        <p class="font-small-3">- ایجاد صفحه تنظیمات ارسال پیامک ها برای   مدیر</p>
                                        <p class="font-small-3">- بهبود ظاهر فرانت در برخی از صفحات</p>

                                    </div>
                                    <small class="text-primary">21 اردیبهشت 1400</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.3</p>
                                        <p class="font-small-3">- دیتاتیبل برای لیست محصولات</p>
                                        <p class="font-small-3">- رفع باگ های جزئی</p>
                                        <p class="font-small-3">- حذف محدودیت قیمت برای محصولات</p>
                                        <p class="font-small-3">- افزودن فیلد دسته بندی ها برای محصول</p>
                                        <p class="font-small-3">- نمایش بهتر فیلد دسته بندی در ایجاد محصول</p>
                                        <p class="font-small-3">- تغییر رنگ پیش فرض سایدبار در پنل مدیریت</p>
                                        <p class="font-small-3">- انتخاب دسته بندی های قابل نمایش در صفحه اصلی توسط مدیر</p>
                                        <p class="font-small-3">- افزودن بروزرسانی خودکار</p>
                                        <p class="font-small-3">- دیتاتیبل برای لیست کاربران</p>
                                        <p class="font-small-3">- تغییر  پکیج احراز هویت</p>
                                        <p class="font-small-3">- اضافه شدن بخش تیکت ها</p>
                                    </div>
                                    <small class="text-primary">11 اردیبهشت 1400</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.2</p>
                                        <p class="font-small-3">- اضافه شدن درگاه زرین پال</p>
                                        <p class="font-small-3">- رفع باگ های جزئی</p>
                                        <p class="font-small-3">- امکان شخصی سازی ظاهر قالب مدیریت برای مدیران</p>
                                        <p class="font-small-3">- اضافه شدن دیتاتیبل و امکان فیلتر کردن لیست تراکنش ها</p>
                                    </div>
                                    <small class="text-primary">29 اسفند 1399</small>
                                </li>
                                <li>
                                    <div class="timeline-icon bg-success">
                                        <i class="feather icon-chevron-left font-medium-2 align-middle"></i>
                                    </div>
                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">نسخه 1.0.0</p>
                                        <p class="font-small-3">- انتشار اولین نسخه</p>
                                    </div>
                                    <small class="text-primary">09 اسفند 1399</small>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/developer/updater.js') }}"></script>
@endpush
