<li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
        data-toggle="dropdown"><i class="ficon feather icon-bell"></i><span
            class="badge badge-pill badge-primary badge-up">{{ $notifications->count() ?: '' }}</span></a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
        <li class="dropdown-menu-header">
            <div class="dropdown-header m-0 p-2">
                <h4 class="white">{{ $notifications->count() }} اعلان جدید</h4>
            </div>
        </li>
        <li class="scrollable-container media-list">
            @foreach ($notifications as $notification)
                @if($notification->type == 'OrderPaid')

                    <a class="d-flex justify-content-between" href="{{ route('admin.notifications') }}">
                        <div class="media d-flex align-items-start">
                            <div class="media-left"><i class="feather icon-plus-square font-medium-5 primary"></i></div>
                            <div class="media-body">
                                <h6 class="primary media-heading">سفارش جدید ثبت شد</h6><small
                                    class="notification-text">{{ $notification->data['message'] }}</small>
                            </div><small>
                                <time class="media-meta">{{ jdate($notification->created_at)->ago() }}</time></small>
                        </div>
                    </a>

                @elseif($notification->type == 'UserRegistered')
                    <a class="d-flex justify-content-between" href="{{ route('admin.notifications') }}">
                        <div class="media d-flex align-items-start">
                            <div class="media-left"><i class="feather icon-user font-medium-5 success"></i></div>
                            <div class="media-body">
                                <h6 class="success media-heading">کاربر جدید ثبت نام کرد</h6><small
                                    class="notification-text">{{ $notification->data['message'] }}</small>
                            </div><small>
                                <time class="media-meta">{{ jdate($notification->created_at)->ago() }}</time></small>
                        </div>
                    </a>

                @elseif($notification->type == 'ContactCreated')
                    <a class="d-flex justify-content-between" href="{{ route('admin.notifications') }}">
                        <div class="media d-flex align-items-start">
                            <div class="media-left"><i class="feather icon-message-square font-medium-5 info"></i></div>
                            <div class="media-body">
                                <h6 class="info media-heading">پیام جدید دریافت شد</h6><small
                                    class="notification-text">{{ $notification->data['message'] }}</small>
                            </div><small>
                                <time class="media-meta">{{ jdate($notification->created_at)->ago() }}</time></small>
                        </div>
                    </a>
                @endif
            @endforeach
        </li>
        <li class="dropdown-menu-footer">
            <a class="dropdown-item p-1 text-center" href="{{ route('admin.notifications') }}">نمایش همه اعلان ها</a>
        </li>
    </ul>
</li>
