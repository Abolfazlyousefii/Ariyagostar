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
                                    <li class="breadcrumb-item">مدیریت قالب ها
                                    </li>
                                    <li class="breadcrumb-item active">لیست قالب ها
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="main-card" class="content-body">

                @if(count($themes))
                    <section>
                        <div class="row">
                            @foreach ($themes as $theme)
                                @if (!$theme['config'])
                                    @continue
                                @endif
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-content">
                                            <img class="card-img-top img-fluid" src="{{ asset($theme['config']['asset_path'] . $theme['config']['demo']['image']) }}" alt="{{ $theme['config']['demo']['name'] }}">
                                            <div class="card-body">
                                                <h5>{{ $theme['config']['demo']['name'] }}</h5>
                                                <p class="card-text  mb-0">{{ $theme['config']['demo']['description'] }}</p>

                                                @if (!get_current_theme() || get_current_theme()['name'] != $theme['name'])
                                                    <div class="card-btns d-flex justify-content-between mt-2">
                                                        <button data-action="{{ route('admin.themes.update', ['theme' => $theme['name']]) }}" type="button" class="btn btn-outline-primary set-as-theme">تنظیم به عنوان قالب</button>
                                                        <button data-name="{{ $theme['name'] }}" type="button" class="btn btn-outline-danger btn-delete" data-toggle="modal" data-target="#delete-modal">حذف</button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @else
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست قالب ها</h4>
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

    {{-- delete theme modal --}}
    <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel19" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    با حذف قالب دیگر قادر به بازیابی آن نخواهید بود
                </div>
                <div class="modal-footer">
                    <form action="#" id="theme-delete-form">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">خیر</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">بله حذف شود</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/themes/index.js') }}"></script>
@endpush
