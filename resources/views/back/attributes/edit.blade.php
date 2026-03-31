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
                                <li class="breadcrumb-item">مدیریت ویژگی ها
                                </li>
                                <li class="breadcrumb-item active">ویرایش ویژگی
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
                    <h4 class="card-title">ویرایش ویژگی </h4>
                </div>

                <div id="main-card" class="card-content">
                    <div class="card-body">
                        <div class="col-12 col-md-10 offset-md-1">
                            <form class="form" id="attribute-edit-form" action="{{ route('admin.attributes.update', ['attribute' => $attribute]) }}">
                                @csrf
                                @method('put')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>نام</label>
                                                <input type="text" class="form-control" name="name" value="{{ $attribute->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>گروه ویژگی ها</label>
                                                <select class="form-control" name="attribute_group_id">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($attributeGroups as $attributeGroup)
                                                        <option data-type="{{ $attributeGroup->type }}" value="{{ $attributeGroup->id }}" {{ $attribute->attribute_group_id == $attributeGroup->id ? 'selected' : '' }}>{{ $attributeGroup->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div id="color-select-div" class="col-md-6 col-12" style="display: none;">
                                            <div class="form-group">
                                                <label>مقدار</label>
                                                <input type="color" class="form-control" name="value" value="{{ $attribute->value }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>ترتیب</label>
                                                <input type="number" class="form-control" name="ordering" value="{{ $attribute->ordering }}">
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-primary mb-1 waves-effect waves-light">ویرایش ویژگی</button>
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

    <script src="{{ asset('back/assets/js/pages/attributes/edit.js') }}"></script>
    <script src="{{ asset('back/assets/js/pages/attributes/all.js') }}"></script>
@endpush