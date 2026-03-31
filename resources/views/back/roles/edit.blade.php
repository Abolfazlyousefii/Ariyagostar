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
                                <li class="breadcrumb-item">مدیریت مقام ها
                                </li>

                                <li class="breadcrumb-item active">ویرایش مقام
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="content-body">
            <!-- Description -->
            <section id="description" class="card">
                <div class="card-header">
                    <h4 class="card-title"> ویرایش مقام</h4>
                </div>

                <div id="main-card" class="card-content">
                    <div class="card-body">
                        <div class="card-body">
                            <form id="role-create-form" action="{{ route('admin.roles.update', ['role' => $role]) }}">
                                @csrf
                                @method('put')

                                <div class="row">
                                    <div class="col-md-6 offset-md-3 col-12">
                                        <div class="form-group">
                                            <label>عنوان</label>
                                            <input type="text" class="form-control" name="title" value="{{ $role->title }}" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6 offset-md-3 col-12">
                                        <div class="form-group">
                                            <label>توضیحات</label>
                                            <textarea class="form-control" name="description" rows="2">{{ $role->description }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <h6>دسترسی ها</h6>

                                @foreach ($permissions as $permission)
                                    <div class="row permissions-row">
                                        <div class="col-md-12">
                                            <div class="card m-0">
                                                <div class="card-header p-0">
                                                        <fieldset>
                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                <input data-id={{ $permission->id }} class="permission-input parent-permission" name="permissions[]" type="checkbox" value="{{ $permission->id }}" {{ $role->permissions()->find($permission->id) ? 'checked' : '' }}>
                                                                <span class="vs-checkbox ">
                                                                    <span class="vs-checkbox--check">
                                                                        <i class="vs-icon feather icon-check"></i>
                                                                    </span>
                                                                </span>
                                                                <span class="main-permissions">{{ $permission->title }}</span>
                                                            </div>
                                                        </fieldset>
                                                    @if ($permission->permissions()->where('active', true)->count())
                                                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                        <div class="heading-elements">
                                                            <ul class="list-inline mb-0">
                                                                <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="card-content collapse {{ $role->permissions()->find($permission->id) ? 'show' : '' }}">
                                                    <div class="card-body p-0">
                                                        <div class="row">
                                                            @foreach ($permission->permissions()->where('active', true)->get() as $item)
                                                                <div class="col-md-3 mt-2">
                                                                    <div class="custom-control custom-checkbox custom-checkbox-success">
                                                                        <input id="checkbox-{{ $item->id }}" data-permission_id="{{ $item->permission_id }}" type="checkbox" class="custom-control-input permission-input" name="permissions[]" value="{{ $item->id }}" {{ $role->permissions()->find($item->id) ? 'checked' : '' }}>
                                                                        <label class="custom-control-label" for="checkbox-{{ $item->id }}">{{ $item->title }}</label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">ویرایش مقام</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
    <script src="{{ asset('back/assets/js/pages/roles/all.js') }}"></script>
    <script src="{{ asset('back/assets/js/pages/roles/create.js') }}"></script>
@endpush
