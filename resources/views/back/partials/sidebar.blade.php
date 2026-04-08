<div class="main-menu menu-fixed menu-accordion menu-shadow {{ user_option('theme_color') == 'light' ? 'menu-light' : 'menu-dark' }}" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{ Route::has('front.index') ? route('front.index') : url('/') }}" target="_blank">
                    <h2 class="brand-text mb-0">{{ option('info_site_title', 'لاراول شاپ') }}</h2>
                </a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            <li class="{{ active_class('admin.dashboard') }} nav-item"><a href="{{ route('admin.dashboard') }}">
                    <i class="feather icon-home"></i>
                    <span class="menu-title">داشبورد</span>
                </a>
            </li>

            @can('users')
                <li class="nav-item has-sub {{ open_class(['admin.users.*']) }}"><a href="#"><i class="feather icon-users"></i><span class="menu-title" > کاربران</span></a>
                    <ul class="menu-content">
                        @can('users.index')
                            <li class="{{ active_class('admin.users.index') }}">
                                <a href="{{ route('admin.users.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست کاربران</span></a>
                            </li>
                        @endcan

                        @can('users.create')
                            <li class="{{ active_class('admin.users.create') }}">
                                <a href="{{ route('admin.users.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد کاربر</span></a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endcan

            @can('posts')
                <li class="nav-item has-sub {{ open_class(['admin.posts.*']) }}"><a href="#"><i class="feather icon-file-text"></i><span class="menu-title" > وبلاگ</span></a>
                    <ul class="menu-content">
                        @can('posts.index')
                            <li class="{{ active_class('admin.posts.index') }}">
                                <a href="{{ route('admin.posts.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست نوشته ها</span></a>
                            </li>
                        @endcan

                        @can('posts.create')
                            <li class="{{ active_class('admin.posts.create') }}">
                                <a href="{{ route('admin.posts.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد نوشته</span></a>
                            </li>
                        @endcan

                        @can('posts.category')
                            <li class="{{ active_class('admin.posts.categories.index') }}">
                                <a href="{{ route('admin.posts.categories.index') }}"><i class="feather icon-circle"></i><span class="menu-item">دسته بندی ها</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('products')
                <li class="nav-item has-sub {{ open_class(['admin.products.*', 'admin.brands.*', 'admin.sizetypes.*']) }}"><a href="#"><i class="feather icon-shopping-cart"></i><span class="menu-title" > محصولات</span></a>
                    <ul class="menu-content">
                        @can('products.index')
                            <li class="{{ active_class('admin.products.index') }}">
                                <a href="{{ route('admin.products.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست محصولات</span></a>
                            </li>
                        @endcan

                        @can('products.create')
                            <li class="{{ active_class('admin.products.create') }}">
                                <a href="{{ route('admin.products.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد محصول</span></a>
                            </li>
                        @endcan

                        @can('products.create')
                            <li class="{{ active_class('admin.products.import.*') }}">
                                <a href="{{ route('admin.products.import.index') }}"><i class="feather icon-circle"></i><span class="menu-item">ایمپورت محصولات</span></a>
                            </li>
                        @endcan

                        @can('products.category')
                            <li class="{{ active_class('admin.products.categories.index') }}">
                                <a href="{{ route('admin.products.categories.index') }}"><i class="feather icon-circle"></i><span class="menu-item">دسته بندی ها</span></a>
                            </li>
                        @endcan

                        @can('products.sizetypes')
                            <li class="{{ active_class('admin.sizetypes.index') }}">
                                <a href="{{ route('admin.sizetypes.index') }}"><i class="feather icon-circle"></i><span class="menu-item">راهنمای سایز</span></a>
                            </li>
                        @endcan

                        @can('products.spectypes')
                            <li class="{{ active_class('admin.spectypes.index') }}">
                                <a href="{{ route('admin.spectypes.index') }}"><i class="feather icon-circle"></i><span class="menu-item">نوع مشخصات</span></a>
                            </li>
                        @endcan

                        @can('products.stock-notify')
                            <li class="{{ active_class('admin.stock-notifies.index') }}">
                                <a href="{{ route('admin.stock-notifies.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست اطلاع از موجودی</span></a>
                            </li>
                        @endcan

                        @can('products.prices')
                            <li class="{{ active_class('admin.product.prices.index') }}">
                                <a href="{{ route('admin.product.prices.index') }}"><i class="feather icon-circle"></i><span class="menu-item">قیمت ها</span></a>
                            </li>
                        @endcan

                        @can('products.prices')
                            <li class="{{ active_class('admin.prices.index') }}">
                                <a href="{{ route('admin.prices.index') }}"><i class="feather icon-circle"></i><span class="menu-item">تغییر قیمت گروهی</span></a>
                            </li>
                        @endcan

                        @can('products.prices')
                            <li class="{{ active_class('admin.product.torobPrices') }}">
                                <a href="{{ route('admin.product.torobPrices') }}"><i class="feather icon-circle"></i><span class="menu-item">مقایسه قیمت ترب</span></a>
                            </li>
                        @endcan

                        @can('products.brands')
                            <li class="{{ open_class(['admin.brands.*']) }}">
                                <a href="#"><i class="feather icon-circle"></i><span class="menu-item"> برندها</span></a>
                                <ul class="menu-content">
                                    <li class="{{ active_class('admin.brands.index') }}">
                                        <a class="{{ active_class('admin.brands.index') }}" href="{{ route('admin.brands.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست برندها</span></a>
                                    </li>
                                    <li class="{{ active_class('admin.brands.create') }}">
                                        <a class="{{ active_class('admin.brands.create') }}" href="{{ route('admin.brands.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد برند</span></a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('attributes')
                            <li class="{{ open_class(['admin.attributeGroups.*']) }}">
                                <a href="#"><i class="feather icon-circle"></i><span class="menu-item"> ویژگی ها</span></a>
                                <ul class="menu-content">
                                    @can('attributes.groups.index')
                                        <li class="{{ active_class('admin.attributeGroups.index') }}">
                                            <a class="{{ active_class('admin.attributeGroups.index') }}" href="{{ route('admin.attributeGroups.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست گروه ویژگی ها</span></a>
                                        </li>
                                    @endcan

                                    @can('attributes.groups.create')
                                        <li class="{{ active_class('admin.attributeGroups.create') }}">
                                            <a class="{{ active_class('admin.attributeGroups.create') }}" href="{{ route('admin.attributeGroups.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد گروه ویژگی</span></a>
                                        </li>
                                    @endcan

                                    @can('attributes.create')
                                        <li class="{{ active_class('admin.attributes.create') }}">
                                            <a class="{{ active_class('admin.attributes.create') }}" href="{{ route('admin.attributes.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد ویژگی</span></a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan

                        @can('filters')
                            <li class="{{ open_class(['admin.filters.*']) }}">
                                <a href="#"><i class="feather icon-circle"></i><span class="menu-item"> فیلترها</span></a>
                                <ul class="menu-content">
                                    @can('filters.index')
                                        <li class="{{ active_class('admin.filters.index') }}">
                                            <a class="{{ active_class('admin.filters.index') }}" href="{{ route('admin.filters.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست فیلتر ها</span></a>
                                        </li>
                                    @endcan

                                    @can('filters.create')
                                        <li class="{{ active_class('admin.filters.create') }}">
                                            <a class="{{ active_class('admin.filters.create') }}" href="{{ route('admin.filters.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد فیلتر</span></a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endcan

            @can('discounts')
                <li class="nav-item has-sub {{ open_class(['admin.discounts.*']) }}"><a href="#"><i class="feather icon-tag"></i><span class="menu-title"> تخفیف ها</span></a>
                    <ul class="menu-content">
                        <li class="{{ active_class('admin.discounts.index') }}">
                            <a class="{{ active_class('admin.discounts.index') }}" href="{{ route('admin.discounts.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست تخفیف ها</span></a>
                        </li>

                        <li class="{{ active_class('admin.discounts.create') }}">
                            <a class="{{ active_class('admin.discounts.create') }}" href="{{ route('admin.discounts.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد تخفیف</span></a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('orders')
                <li class="nav-item has-sub {{ open_class(['admin.orders.*']) }}"><a href="#"><i class="feather icon-briefcase"></i><span class="menu-title" > سفارشات</span></a>
                    <ul class="menu-content">
                        @can('orders.index')
                            <li class="{{ active_class('admin.orders.index') }}">
                                <a href="{{ route('admin.orders.index') }}"><i class="feather icon-circle"></i><span class="menu-item">همه سفارشات</span></a>
                            </li>
                        @endcan

                        @can('orders.index')
                            <li class="">
                                <a href="{{ route('admin.orders.index') }}?status=paid&shipping_status=pending&type=online"><i class="feather icon-circle"></i><span class="menu-item">سفارشات جدید</span></a>
                            </li>
                        @endcan

                        @can('orders.index')
                            <li class="">
                                <a href="{{ route('admin.orders.index') }}?status=paid"><i class="feather icon-circle"></i><span class="menu-item">سفارشات پرداخت شده</span></a>
                            </li>
                        @endcan

                        @can('orders.index')
                            <li class="">
                                <a href="{{ route('admin.orders.index') }}?status=paid&shipping_status=reserved"><i class="feather icon-circle"></i><span class="menu-item">سفارشات رزرو شده</span></a>
                            </li>
                        @endcan

                        @can('orders.index')
                            <li class="{{ active_class('admin.orders.notCompleted') }}">
                                <a href="{{ route('admin.orders.notCompleted') }}"><i class="feather icon-circle"></i><span class="menu-item"> محصولات منتظر ارسال</span></a>
                            </li>
                        @endcan

                        @can('orders.create')
                            <li class="{{ active_class('admin.orders.create') }}">
                                <a href="{{ route('admin.orders.create') }}"><i class="feather icon-circle"></i><span class="menu-item"> افزودن سفارش</span></a>
                            </li>
                        @endcan

                        @can('orders.create')
                            <li class="{{ active_class('admin.orders.inPersonCreate') }}">
                                <a href="{{ route('admin.orders.inPersonCreate') }}"><i class="feather icon-circle"></i><span class="menu-item"> افزودن سفارش حضوری</span></a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endcan

            @can('carriers')
                <li class="nav-item has-sub {{ open_class(['admin.provinces.*', 'admin.carriers.*', 'admin.tariffs.*']) }}"><a href="#"><i class="feather icon-package"></i><span class="menu-title"> حمل و نقل</span></a>
                    <ul class="menu-content">
                        <li class="{{ active_class('admin.carriers.index') }}">
                            <a class="{{ active_class('admin.carriers.index') }}" href="{{ route('admin.carriers.index') }}"><i class="feather icon-circle"></i><span class="menu-item">روش های ارسال</span></a>
                        </li>

                        @can('carriers.provinces.index')
                            <li class="{{ active_class('admin.provinces.index') }}">
                                <a class="{{ active_class('admin.provinces.index') }}" href="{{ route('admin.provinces.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست استان ها</span></a>
                            </li>
                        @endcan

                        @can('carriers.provinces.create')
                            <li class="{{ active_class('admin.provinces.create') }}">
                                <a class="{{ active_class('admin.provinces.create') }}" href="{{ route('admin.provinces.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد استان</span></a>
                            </li>
                        @endcan

                        @can('carriers.cities.create')
                            <li class="{{ active_class('admin.cities.create') }}">
                                <a class="{{ active_class('admin.cities.create') }}" href="{{ route('admin.cities.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد شهر</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('sliders')
                <li class="nav-item has-sub {{ open_class(['admin.sliders.*']) }}"><a href="#"><i class="feather icon-sliders"></i><span class="menu-title" > اسلایدرها</span></a>
                    <ul class="menu-content">
                        @can('sliders.index')
                            <li class="{{ active_class('admin.sliders.index') }}">
                                <a href="{{ route('admin.sliders.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست اسلایدرها</span></a>
                            </li>
                        @endcan

                        @can('sliders.create')
                            <li class="{{ active_class('admin.sliders.create') }}">
                                <a href="{{ route('admin.sliders.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد اسلایدر</span></a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endcan

            @can('banners')
                <li class="nav-item has-sub {{ open_class(['admin.banners.*']) }}"><a href="#"><i class="feather icon-image"></i><span class="menu-title" > بنرها</span></a>
                    <ul class="menu-content">
                        @can('banners.index')
                            <li class="{{ active_class('admin.banners.index') }}">
                                <a href="{{ route('admin.banners.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست بنرها</span></a>
                            </li>
                        @endcan

                        @can('banners.create')
                            <li class="{{ active_class('admin.banners.create') }}">
                                <a href="{{ route('admin.banners.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد بنر</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('links')
                <li class="nav-item has-sub {{ open_class(['admin.links.*']) }}"><a href="#"><i class="feather icon-link"></i><span class="menu-title" > لینک های فوتر</span></a>
                    <ul class="menu-content">
                        @can('links.index')
                            <li class="{{ active_class('admin.links.index') }}">
                                <a href="{{ route('admin.links.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست لینک ها</span></a>
                            </li>
                        @endcan

                        @can('links.create')
                            <li class="{{ active_class('admin.links.create') }}">
                                <a href="{{ route('admin.links.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد لینک </span></a>
                            </li>
                        @endcan

                        @can('links.groups')
                            <li class="{{ active_class('admin.links.groups.index') }}">
                                <a href="{{ route('admin.links.groups.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست گروه ها </span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('pages')
                <li class="nav-item has-sub {{ open_class(['admin.pages.*']) }}"><a href="#"><i class="feather icon-file"></i><span class="menu-title" > صفحات</span></a>
                    <ul class="menu-content">
                        @can('pages.index')
                            <li class="{{ active_class('admin.pages.index') }}">
                                <a href="{{ route('admin.pages.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست صفحات</span></a>
                            </li>
                        @endcan

                        @can('pages.create')
                            <li class="{{ active_class('admin.pages.create') }}">
                                <a href="{{ route('admin.pages.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد صفحه</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('roles')
                <li class="nav-item has-sub {{ open_class(['admin.roles.*']) }}"><a href="#"><i class="feather icon-unlock"></i><span class="menu-title" > مقام ها</span></a>
                    <ul class="menu-content">
                        @can('roles.index')
                            <li class="{{ active_class('admin.roles.index') }}">
                                <a href="{{ route('admin.roles.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست مقام ها</span></a>
                            </li>
                        @endcan

                        @can('roles.create')
                            <li class="{{ active_class('admin.roles.create') }}">
                                <a href="{{ route('admin.roles.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد مقام</span></a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endcan

            @can('statistics')
                <li class="nav-item has-sub"><a href="#"><i class="feather icon-pie-chart"></i><span class="menu-title" >گزارشات</span></a>
                    <ul class="menu-content">

                        @can('statistics.orders')
                            <li class="{{ active_class('admin.statistics.orders') }}">
                                <a href="{{ route('admin.statistics.orders') }}"><i class="feather icon-circle"></i><span class="menu-item">سفارشات</span></a>
                            </li>
                        @endcan

                        @can('statistics.users')
                            <li class="{{ active_class('admin.statistics.users') }}">
                                <a href="{{ route('admin.statistics.users') }}"><i class="feather icon-circle"></i><span class="menu-item">کاربران</span></a>
                            </li>
                        @endcan

                        @can('statistics.views')
                            <li class="{{ active_class('admin.statistics.views') }}">
                                <a href="{{ route('admin.statistics.views') }}"><i class="feather icon-circle"></i><span class="menu-item">آمار بازدیدها</span></a>
                            </li>
                        @endcan

                        @can('statistics.orders')
                            <li class="{{ active_class('admin.statistics.bestSellingProducts') }}">
                                <a href="{{ route('admin.statistics.bestSellingProducts') }}"><i class="feather icon-circle"></i><span class="menu-item">محصولات پرفروش</span></a>
                            </li>
                        @endcan

                        @can('statistics.orders')
                            <li class="{{ active_class('admin.statistics.cityReport') }}">
                                <a href="{{ route('admin.statistics.cityReport') }}"><i class="feather icon-circle"></i><span class="menu-item"> سفارشات شهرها</span></a>
                            </li>
                        @endcan

                        @can('statistics.orders')
                            <li class="{{ active_class('admin.statistics.stockReport') }}">
                                <a href="{{ route('admin.statistics.stockReport') }}"><i class="feather icon-circle"></i><span class="menu-item">موجودی محصولات</span></a>
                            </li>
                        @endcan

                        @can('statistics.orders')
                            <li class="{{ active_class('admin.statistics.userOrders') }}">
                                <a href="{{ route('admin.statistics.userOrders') }}"><i class="feather icon-circle"></i><span class="menu-item">سفارش کاربران</span></a>
                            </li>
                        @endcan

                        @can('statistics.viewsList')
                            <li class="{{ active_class('admin.statistics.viewsList') }}">
                                <a href="{{ route('admin.statistics.viewsList') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست بازدیدها</span></a>
                            </li>
                        @endcan

                        @can('statistics.viewers')
                            <li class="{{ active_class('admin.statistics.viewers') }}">
                                <a href="{{ route('admin.statistics.viewers') }}"><i class="feather icon-circle"></i><span class="menu-item"> بازدید کنندگان امروز</span></a>
                            </li>
                        @endcan

                        @can('statistics.sms')
                            <li class="{{ active_class('admin.statistics.smsLog') }}">
                                <a href="{{ route('admin.statistics.smsLog') }}"><i class="feather icon-circle"></i><span class="menu-item"> لاگ پیامک های ارسالی</span></a>
                            </li>
                        @endcan


                    </ul>
                </li>
            @endcan

            @can('themes')
                <li class="nav-item has-sub {{ open_class(['admin.themes.*', 'admin.widgets.*']) }}"><a href="#"><i class="feather icon-layout"></i><span class="menu-title" >قالب </span></a>
                    <ul class="menu-content">
                        @can('themes.index')
                            <li class="{{ active_class('admin.themes.index') }}">
                                <a href="{{ route('admin.themes.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست قالب ها</span></a>
                            </li>
                        @endcan

                        @can('themes.create')
                            <li class="{{ active_class('admin.themes.create') }}">
                                <a href="{{ route('admin.themes.create') }}"><i class="feather icon-circle"></i><span class="menu-item">افزودن قالب جدید</span></a>
                            </li>
                        @endcan

                        @can('themes.settings')
                            @if(config('front.settings.fields'))
                                <li class="{{ active_class('admin.themes.settings') }}">
                                    <a href="{{ route('admin.themes.settings') }}"><i class="feather icon-circle"></i><span class="menu-item">تنظیمات قالب</span></a>
                                </li>
                            @endcan
                        @endcan

                        @can('themes.settings')
                            @if (config('front.home-widgets'))
                                <li class="{{ active_class('admin.widgets.index') }}">
                                    <a href="{{ route('admin.widgets.index') }}"><i class="feather icon-circle"></i><span class="menu-item">مدیریت صفحه اصلی</span></a>
                                </li>
                            @endif
                        @endcan

                    </ul>
                </li>
            @endcan

            @can('tickets')
                <li class="nav-item has-sub {{ open_class(['admin.tickets.*']) }}"><a href="#"><i class="feather icon-inbox"></i><span class="menu-title" > تیکت ها</span></a>
                    <ul class="menu-content">
                        @can('tickets.index')
                            <li class="{{ active_class('admin.tickets.index') }}">
                                <a href="{{ route('admin.tickets.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لیست تیکت ها</span></a>
                            </li>
                        @endcan

                        @can('tickets.create')
                            <li class="{{ active_class('admin.tickets.create') }}">
                                <a href="{{ route('admin.tickets.create') }}"><i class="feather icon-circle"></i><span class="menu-item">ایجاد تیکت</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can(['payments'])
                <li class="nav-item has-sub {{ open_class(['admin.transactions.*', 'admin.currencies.*']) }}"><a href="#"><i class="feather icon-credit-card"></i><span class="menu-title" > پرداخت</span></a>
                    <ul class="menu-content">
                        @can('payments.transactions.index')
                            <li class="{{ active_class('admin.transactions.index') }} nav-item">
                                <a href="{{ route('admin.transactions.index') }}">
                                    <i class="feather feather icon-circle"></i>
                                    <span class="menu-title"> لیست تراکنش ها</span>
                                </a>
                            </li>
                        @endcan

                        @can('payments.wallet-histories.index')
                            <li class="{{ active_class('admin.wallet-histories.index') }} nav-item">
                                <a href="{{ route('admin.wallet-histories.index') }}">
                                    <i class="feather feather icon-circle"></i>
                                    <span class="menu-title"> تاریخچه کیف پول</span>
                                </a>
                            </li>
                        @endcan

                        @can('payments.currencies')
                            <li class="{{ active_class('admin.currencies.index') }} nav-item">
                                <a href="{{ route('admin.currencies.index') }}">
                                    <i class="feather feather icon-circle"></i>
                                    <span class="menu-title"> لیست ارز ها</span>
                                </a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endcan

            @can(['comments'])
                <li class="nav-item has-sub {{ open_class(['admin.comments.*']) }}"><a href="#"><i class="feather icon-message-circle"></i><span class="menu-title" > نظرات</span></a>
                    <ul class="menu-content">

                        <li class="{{ active_class('admin.comments.products') }} nav-item">
                            <a href="{{ route('admin.comments.products') }}">
                                <i class="feather feather icon-circle"></i>
                                <span class="menu-title"> پرسش و پاسخ محصولات</span>
                            </a>
                        </li>
                        <li class="{{ active_class('admin.reviews.index') }} nav-item">
                            <a href="{{ route('admin.reviews.index') }}">
                                <i class="feather feather icon-circle"></i>
                                <span class="menu-title"> نظرات محصولات</span>
                            </a>
                        </li>
                        <li class="{{ active_class('admin.comments.posts') }} nav-item">
                            <a href="{{ route('admin.comments.posts') }}">
                                <i class="feather feather icon-circle"></i>
                                <span class="menu-title"> نظرات وبلاگ</span>
                            </a>
                        </li>

                    </ul>
                </li>
            @endcan

            @can('menus')
                <li class="{{ active_class('admin.menus.index') }} nav-item">
                    <a href="{{ route('admin.menus.index') }}">
                        <i class="feather icon-menu"></i>
                        <span class="menu-title"> منوها</span>
                    </a>
                </li>
            @endcan

            @can('contacts')
                <li class="{{ active_class('admin.contacts.index') }} nav-item">
                    <a href="{{ route('admin.contacts.index') }}">
                        <i class="feather icon-message-square"></i>
                        <span class="menu-title">لیست تماس با ما</span>
                    </a>
                </li>
            @endcan

            @can('settings')
                <li class="nav-item has-sub">
                    <a href="#">
                        <i class="feather icon-settings"></i>
                        <span class="menu-title" >تنظیمات</span>
                    </a>
                    <ul class="menu-content">
                        @can('settings.information')
                            <li class="{{ active_class('admin.settings.information') }}">
                                <a href="{{ route('admin.settings.information') }}"><i class="feather icon-circle"></i><span class="menu-item">اطلاعات کلی</span></a>
                            </li>
                        @endcan

                        @can('settings.socials')
                            @if (config('front.socials'))
                                <li class="{{ active_class('admin.settings.socials') }}">
                                    <a href="{{ route('admin.settings.socials') }}"><i class="feather icon-circle"></i><span class="menu-item">شبکه های اجتماعی</span></a>
                                </li>
                            @endif
                        @endcan


                        @can('settings.information')
                            <li class="{{ active_class('admin.settings.footer') }}">
                                <a href="{{ route('admin.settings.footer') }}"><i class="feather icon-circle"></i><span class="menu-item">مدیریت فوتر</span></a>
                            </li>
                        @endcan

                        @can('settings.gateway')
                            <li class="{{ active_class('admin.settings.gateways') }}">
                                <a href="{{ route('admin.settings.gateways') }}"><i class="feather icon-circle"></i><span class="menu-item">درگاه های پرداخت</span></a>
                            </li>
                        @endcan

                        @can('settings.others')
                            <li class="{{ active_class('admin.settings.others') }}">
                                <a href="{{ route('admin.settings.others') }}"><i class="feather icon-circle"></i><span class="menu-item">تنظیمات دیگر</span></a>
                            </li>
                        @endcan

                        @can('settings.sms')
                            <li class="{{ active_class('admin.settings.sms') }}">
                                <a href="{{ route('admin.settings.sms') }}"><i class="feather icon-circle"></i><span class="menu-item">تنظیمات پیامک</span></a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endcan

            <li class="nav-item has-sub {{ open_class(['admin.file-manager', 'admin.backups.*', 'admin.apikeys.*', 'admin.notifications']) }}">
                <a href="#">
                    <i class="feather icon-more-horizontal"></i>
                    <span class="menu-title">دیگر</span>
                </a>
                <ul class="menu-content">
                    @can('file-manager')
                        <li class="{{ active_class('admin.file-manager') }} nav-item">
                            <a href="{{ route('admin.file-manager') }}">
                                <i class="feather icon-folder"></i>
                                <span class="menu-title"> فایل ها</span>
                            </a>
                        </li>
                    @endcan

                    @can('backups.index')
                        <li class="{{ active_class('admin.backups.index') }} nav-item">
                            <a href="{{ route('admin.backups.index') }}">
                                <i class="feather icon-upload-cloud"></i>
                                <span class="menu-title">لیست بکاپ ها</span>
                            </a>
                        </li>
                    @endcan

                    @can('apikeys.index')
                        <li class="{{ active_class('admin.apikeys.index') }} nav-item">
                            <a href="{{ route('admin.apikeys.index') }}">
                                <i class="fa fa-key"></i>
                                <span class="menu-title">کلیدهای وب سرویس</span>
                            </a>
                        </li>
                    @endcan

                    <li class="{{ active_class('admin.notifications') }} nav-item">
                        <a href="{{ route('admin.notifications') }}">
                            <i class="feather icon-bell"></i>
                            <div class="d-flex justify-content-between w-100">
                                <span class="menu-title"> اعلان ها</span>
                                @if($notifications->count())
                                    <span class="badge badge badge-primary badge-pill"> {{ $notifications->count() }}</span>
                                @endif
                            </div>
                        </a>
                    </li>

                </ul>
            </li>

            @if(auth()->user()->isCreator())
                <li class="nav-item has-sub">
                    <a href="#">
                        <i class="feather icon-alert-octagon"></i>
                        <span class="menu-title" >توسعه دهنده</span>
                        <span class="badge badge-danger badge-pill float-right mr-2">creator</span>
                    </a>
                    <ul class="menu-content">
                        <li class="{{ active_class('admin.permissions.index') }}">
                            <a href="{{ route('admin.permissions.index') }}"><i class="feather icon-circle"></i><span class="menu-item">دسترسی ها</span></a>
                        </li>

                        <li class="{{ active_class('admin.developer.settings') }}">
                            <a href="{{ route('admin.developer.settings') }}"><i class="feather icon-circle"></i><span class="menu-item">تنظیمات توسعه دهنده</span></a>
                        </li>

                        <li class="{{ active_class('admin.logs.index') }}">
                            <a target="_blank" href="{{ route('admin.logs.index') }}"><i class="feather icon-circle"></i><span class="menu-item">لاگ ها</span></a>
                        </li>

                        <li class="{{ active_class('admin.developer.showUpdater') }}">
                            <a href="{{ route('admin.developer.showUpdater') }}"><i class="feather icon-circle"></i><span class="menu-item">بروزرسانی</span></a>
                        </li>
                        @if(option('enable_old_updates') === 'true')
                            <li class="{{ active_class('admin.old.developer.showUpdater') }}">
                                <a href="{{ route('admin.old.developer.showUpdater') }}"><i class="feather icon-circle"></i><span class="menu-item">بروزرسانی قدیمی</span></a>
                            </li>
                        @endif


                    </ul>
                </li>
            @endif

        </ul>
    </div>
</div>
