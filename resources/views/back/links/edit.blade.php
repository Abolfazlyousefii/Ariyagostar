@extends('back.layouts.master')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('back/app-assets/plugins/jquery-ui/jquery-ui.css') }}">
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
                                    <li class="breadcrumb-item">مدیریت لینک ها
                                    </li>
                                    <li class="breadcrumb-item active">ویرایش لینک
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <!-- Description -->
                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">ویرایش لینک  </h4>
                    </div>

                    <div id="main-card" class="card-content">
                        <div class="card-body">
                            <div class="col-12 col-md-10 offset-md-1">
                                <form class="form" id="link-edit-form" action="{{ route('admin.links.update', ['link' => $link]) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="form-body">
                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>عنوان </label>
                                                    <input type="text" class="form-control link-link" name="title" value="{{ $link->title }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>لینک </label>
                                                    <input type="text" class="form-control link-link ltr" name="link" value="{{ $link->link }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label>گروه</label>
                                                    <select class="form-control" name="link_group_id">
                                                        @foreach($groups as $group)
                                                            <option value="{{ $group['key'] }}" {{ $link->link_group_id == $group['key'] ? 'selected' : '' }} >{{ option('link_groups_' . $group['key'], $group['name']) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 text-right">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">ویرایش لینک </button>
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

@push('scripts')
    <script src="{{ asset('back/app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('back/app-assets/plugins/jquery-validation/localization/messages_fa.min.js') }}"></script>
    <script src="{{ asset('back/app-assets/plugins/jquery-ui/jquery-ui.js') }}"></script>

    <script>
        var pages =  [
            @foreach($pages as $page)
                "/pages/{{ $page }}",
            @endforeach
        ];
    </script>

    <script src="{{ asset('back/assets/js/pages/links/edit.js') }}"></script>
@endpush
