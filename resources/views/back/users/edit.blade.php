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
                                    <li class="breadcrumb-item">مدیریت کاربران
                                    </li>
                                    <li class="breadcrumb-item active">ویرایش کاربر
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <!-- Description -->
                <section id="main-card" class="card">
                    <div class="card-header">
                        <h4 class="card-title">ویرایش کاربر </h4>
                    </div>

                    <div id="main-card" class="card-content">
                        <div class="card-body">
                            <div class="col-12 col-md-10 offset-md-1">
                                <form class="form" id="user-edit-form" action="{{ route('admin.users.update', ['user' => $user]) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>نام</label>
                                                    <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>نام خانوادگی</label>
                                                    <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>آدرس ایمیل</label>
                                                    <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>شماره همراه <small>( نام کاربری )</small></label>
                                                    <input type="text" class="form-control ltr" name="username" value="{{ $user->username }}">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            @can('roles')
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>نوع کاربری</label>
                                                        <select id="level" class="form-control" name="level">
                                                            <option {{ $user->level == 'user' ? 'selected' : '' }} value="user">کاربر عادی</option>
                                                            <option {{ $user->level == 'admin' ? 'selected' : '' }} value="admin">مدیر وبسایت</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            @endcan

                                            <div class="col-md-6">
                                                <fieldset class="form-group">
                                                    <label>تصویر</label>
                                                    <div class="custom-file">
                                                        <input id="image" type="file" accept="image/*" name="image" class="custom-file-input">
                                                        <label class="custom-file-label" for="image"></label>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>تاریخ تولد</label>
                                                    <input autocomplete="off" type="text" data-timestamps="false" class="form-control persian-date-picker ltr" name="birthday" value="{{ $user->birthday ? jdate($user->birthday)->getTimestamp() : '' }}">
                                                </div>
                                            </div>
                                        </div>

                                        @can('roles')
                                            <div id="roles-div" class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>انتخاب نقش ها</label>
                                                        <select id="roles" class="form-control" name="roles[]" multiple>
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->id }}" {{ $user->roles()->find($role->id) ? 'selected' : '' }}>{{ $role->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endcan

                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>گذرواژه</label>
                                                    <input type="password" id="password" class="form-control" name="password">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>تکرار گذرواژه</label>
                                                    <input type="password" class="form-control ltr" name="password_confirmation">
                                                </div>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" name="verified_at" {{ $user->verified_at ? 'checked' : '' }}>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span>شماره تلفن تایید شده</span>
                                                    </div>
                                                </fieldset>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">ویرایش کاربر</button>
                                            </div>
                                            <div class="col-12">
                                                <div class="alert alert-info mt-1 alert-validation-msg" role="alert">
                                                    <i class="feather icon-info ml-1 align-middle"></i>
                                                    <span>در صورتی که نمیخواهید گذرواژه را عوض کنید، فیلدهای گذرواژه را خالی بگذارید.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Description -->

            </div>
        </div>
    </div>
@endsection

@include('back.partials.plugins', ['plugins' => ['jquery.validate', 'persian-datepicker']])

@php
    $help_videos = [config('general.video-helpes.users')];
@endphp

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/users/all.js') }}"></script>
    <script src="{{ asset('back/assets/js/pages/users/create.js') }}"></script>
@endpush
