@extends('back.layouts.master')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('back/app-assets/vendors/css/file-uploaders/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('back/app-assets/css-rtl/plugins/file-uploaders/dropzone.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('back/assets/css/pages/tickets/show.css') }}">
@endpush

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
                                    <li class="breadcrumb-item">مدیریت تیکت ها
                                    </li>
                                    <li class="breadcrumb-item active">مشاهده تیکت {{ $ticket->id }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="row">

                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <dt class="col-md-3">کاربر مربوطه :</dt>
                                                    <dd class="col-md-6">
                                                        {{ $ticket->user->fullname }}
                                                        <a href="{{ route('admin.users.show', ['user' => $ticket->user]) }}" target="_blank"><i class="feather icon-external-link"></i></a>
                                                    </dd>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <dt class="col-md-3">تاریخ ایجاد :</dt>
                                                    <dd class="col-md-6">{{ jdate($ticket->created_at) }}</dd>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <dt class="col-md-3">اولویت :</dt>
                                                    <dd class="col-md-6">{{ $ticket->priorityText() }}</dd>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <dt class="col-md-3">وضعیت :</dt>
                                                    <dd class="col-md-6">{{ $ticket->statusText() }}</dd>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 chat-application">
                        <div class="content-right">
                            <div class="content-header row">
                            </div>
                            <div class="content-body">
                                <div class="chat-overlay"></div>
                                <section class="chat-app-window">

                                    <div class="active-chat ">

                                        <div class="user-chats">
                                            <div class="chats">

                                                @foreach ($ticket->messages()->oldest()->get() as $message)

                                                    @if ($loop->first)
                                                        <div class="divider">
                                                            <div class="divider-text">{{ jdate($message->created_at)->ago() }}</div>
                                                        </div>
                                                    @endif

                                                    @if ($message->user->id != auth()->user()->id)
                                                        @include('back.tickets.partials.message', ['own' => true])
                                                    @else
                                                        @include('back.tickets.partials.message', ['own' => false])
                                                    @endif

                                                @endforeach

                                            </div>
                                        </div>

                                    </div>
                                </section>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-2">
                        <section class="card">

                            <div id="main-card" class="card-content">
                                <div class="card-body">
                                    <div class="col-12 col-md-10 offset-md-1">
                                        <form class="form" id="ticket-update-form" action="{{ route('admin.tickets.update', ['ticket' => $ticket]) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <div class="form-body">
                                                <div class="row">

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="message">پیام</label>
                                                            <textarea id="message" class="form-control" rows="4" name="message"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label>فایل های پیوست</label>

                                                        <div class="dropzone dropzone-area mb-2" id="ticket-file-dropzone" data-url="{{ route('admin.tickets.file.store') }}" data-remove-url="{{ route('admin.tickets.file.destroy') }}">
                                                            <div class="dz-message">فایل ها را به اینجا بکشید</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">ارسال پیام</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('back/app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('back/app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('back/app-assets/plugins/jquery-validation/localization/messages_fa.min.js') }}"></script>

    <script src="{{ asset('back/assets/js/pages/tickets/show.js') }}"></script>
    <script src="{{ asset('back/assets/js/pages/tickets/all.js') }}"></script>
@endpush
