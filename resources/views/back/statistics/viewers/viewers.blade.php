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
                                    <li class="breadcrumb-item">گزارشات
                                    </li>
                                    <li class="breadcrumb-item active">بازدید کنندگان
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                @if($viewers->count())
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست بازدید کنندگان</h4>
                        </div>
                        <div class="card-content" id="main-card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>کاربر</th>
                                                <th style="min-width: 200px;">آخرین بازدید</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($viewers as $viewer)
                                                <tr>
                                                    <td>
                                                        @if ($viewer->user)
                                                            {{ $viewer->user->fullname }} <a href="{{ route('admin.users.show', ['user' => $viewer->user]) }}" target="_blank"><i class="feather icon-external-link"></i></a>
                                                        @else
                                                            --
                                                        @endif
                                                    </td>
                                                    <td class="ltr">{{ jdate($viewer->created_at) }}</td>
                                                    <td>{{ $viewer->ip }}</td>
                                                    <td>{{ get_option_property($viewer->options, 'platform') }}</td>
                                                    <td class="ltr text-right"><a class="text-dark" target="_blank" href="{{ url(urldecode($viewer->path)) }}">{{ urldecode($viewer->path) }}</a></td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>

                @else
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست بازدید کنندگان</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="card-text">
                                    <p>چیزی برای نمایش وجود ندارد!</p>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif


            </div>
        </div>
    </div>
@endsection
