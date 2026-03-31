<div class="content-overlay"></div>
<div class="header-navbar-shadow"></div>
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto">
                            <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                                <i class="ficon feather icon-menu"></i>
                            </a>
                        </li>
                    </ul>

                </div>
                <ul class="nav navbar-nav float-right align-items-center">
                    @if (option('multi_language_enabled'))
                        <li class="dropdown dropdown-language nav-item">
                            <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="selected-language">{{ $current_local['name'] }}</span></a>
                            <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                                @foreach (get_langs() as $key => $lang)
                                    <a class="dropdown-item" href="{{ get_current_url($key) }}"> {{ $lang['name'] }}</a>
                                @endforeach
                            </div>
                        </li>
                    @endif

                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand">
                        <i class="ficon feather icon-maximize"></i></a>
                    </li>

                    @include('back.partials.notifications')

                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">{{ auth()->user()->name }}</span></div>
                            <span><img class="round" src="{{ auth()->user()->imageUrl }}" alt="avatar" height="40" width="40"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="{{ route('admin.user.profile.show') }}">
                            <i class="feather icon-user"></i> ویرایش پروفایل</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                <i  class="feather icon-power"></i> خروج
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
