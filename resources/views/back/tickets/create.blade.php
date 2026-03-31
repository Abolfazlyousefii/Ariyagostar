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
                                    <li class="breadcrumb-item">مدیریت تیکت ها
                                    </li>
                                    <li class="breadcrumb-item active">ایجاد تیکت
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">ایجاد تیکت جدید</h4>
                    </div>

                    <div id="main-card" class="card-content">
                        <div class="card-body">
                            <div class="col-12 col-md-10 offset-md-1">
                                <form class="form" id="ticket-create-form" data-redirect="{{ route('admin.tickets.index') }}" action="{{ route('admin.tickets.store') }}" method="post">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>موضوع</label>
                                                    <input type="text" class="form-control" name="subject">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>اولویت</label>
                                                    <select name="priority" class="form-control">
                                                        <option value="low">کم</option>
                                                        <option value="medium">متوسط</option>
                                                        <option value="hight">زیاد</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>کاربر مربوطه</label>
                                                    <select id="user_id" name="user_id" class="form-control">
                                                        <option value=""></option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

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
                                                <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">ایجاد تیکت</button>
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

@endsection

@include('back.partials.plugins', ['plugins' => ['dropzone', 'jquery.validate']])

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/tickets/all.js') }}"></script>
    <script src="{{ asset('back/assets/js/pages/tickets/create.js') }}"></script>
@endpush
