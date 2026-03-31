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
                                    <li class="breadcrumb-item">تنظیمات
                                    </li>
                                    <li class="breadcrumb-item active">تنظیمات قالب
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                @if (config('front.settings.fields'))
                    <section class="users-edit">
                        <div class="card">
                            <div id="main-card" class="card-content">
                                <div class="card-header">
                                    <h4 class="card-title">تنظیمات قالب</h4>
                                </div>
                                <div class="card-body">

                                    <div class="tab-content">

                                        <form id="theme-settings-form" action="{{ route('admin.themes.settings') }}" method="POST">
                                            <div class="row">

                                                @foreach (config('front.settings.fields') as $setting)

                                                    @switch($setting['input-type'])

                                                        @case('select')
                                                            @include('back.themes.partials.select')
                                                            @break

                                                        @case('input')
                                                            @include('back.themes.partials.input')
                                                            @break

                                                        @case('file')
                                                            @include('back.themes.partials.file')
                                                            @break

                                                        @case('editor')
                                                            <div class="{{ $setting['class'] ?? 'col-md-12 col-12' }}">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>{{ $setting['title'] }}</label>
                                                                        <textarea  name="settings[{{ $setting['key'] }}]" rows="5" class="form-control editor-textarea">{{ option($setting['key']) }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @break

                                                        @case('inline-editor')
                                                            <div class="{{ $setting['class'] ?? 'col-md-12 col-12' }}">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>{{ $setting['title'] }}</label>
                                                                        <textarea  name="settings[{{ $setting['key'] }}]" rows="5" class="form-control inline-editor-textarea">{{ option($setting['key']) }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @break
                                                        @case('linebreak')
                                                            </div>{!! $setting['html'] ?? "" !!}<div class="row">
                                                            @break

                                                    @endswitch

                                                @endforeach

                                            </div>

                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                                <button type="submit" class="btn btn-primary glow">ذخیره تغییرات</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">تنظیمات قالب</h4>
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

@include('back.partials.plugins', ['plugins' => ['jquery.validate', 'ckeditor']])

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/themes/settings.js') }}?v=2"></script>
@endpush
