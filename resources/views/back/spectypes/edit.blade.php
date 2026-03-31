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
                                <li class="breadcrumb-item">مدیریت محصولات
                                </li>
                                <li class="breadcrumb-item active">ویرایش نوع مشخصات
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
                
        <div id="main-card" class="content-body">
            <form id="spectype-edit-form" class="form" action="{{ route('admin.spectypes.update', ['spectype' => $spectype]) }}" method="post">
                @csrf
                @method('put')
                <input type="hidden" name="type" value="physical">
                <div class="row">
                    <div class="col-md-12">
                        
                        <div id="specifications-card" class="card">
                           
                            <div class="card-content">
                                <div class="card-body ">
                                    <div class="row">
                                       
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>نوع مشخصات</label>
                                                <input class="form-control" name="name" placeholder="مثلا گوشی موبایل" value="{{ $spectype->name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-body">
                                        <div id="specifications-area">
                                            @foreach ($spectype->specificationGroups->unique() as $group)
                                                <div class="row mt-2 specification-group">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>نام گروه</label>
                                                            <input type="text" class="form-control group-input" data-group_name="{{ $loop->index }}" name="specification_group[{{ $loop->index }}][name]" placeholder="مثال: مشخصات کلی" value="{{ $group->name }}" required>
                                                        </div>
                                                    </div>
                                            
                                                    <div class="all-specifications col-12">
                                                        @foreach($spectype->specifications()->where('specification_group_id', $group->id)->get() as $specification)
                                                            <div class="single-specificition">
                                                                <div class="row">
                                                                    
                                                                    <div class="col-md-4 form-group">
                                                                        <p class="spec-label">عنوان</p>
                                                                        <input type="text" class="form-control spec-label" name="specification_group[{{ $loop->parent->index }}][specifications][{{ $loop->index }}][name]" placeholder="مثال: حافظه داخلی" value="{{ $specification->name }}" required>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <button type="button" class="btn btn-flat-danger waves-effect waves-light remove-specification custom-padding"><i class="feather icon-minus"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    
                                                    <div class="col-md-12 text-center">
                                                        <button type="button" class="btn btn-flat-success waves-effect waves-light add-specifaction">افزودن مشخصات</button>
                                                        <button type="button" class="btn btn-flat-danger waves-effect waves-light remove-group">حذف گروه</button>
                                            
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-12 text-center mt-4">
                                                <button id="add-spectype-specification-group" type="button" class="btn btn-outline-primary waves-effect waves-light"><i class="feather icon-plus"></i> افزودن گروه مشخصات</button>
                                                <button type="submit" class="btn btn-outline-success waves-effect waves-light">ذخیره تغییرات</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
        
    </div>
</div>

@include('back.spectypes.partials.specification-template')

@endsection

@push('scripts') 

        <script src="{{ asset('back/app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('back/app-assets/plugins/jquery-validation/localization/messages_fa.min.js') }}"></script>
        <script src="{{ asset('back/app-assets/plugins/jquery-ui/jquery-ui.js') }}"></script>
        <script src="{{ asset('back/app-assets/plugins/jquery-ui-sortable/jquery-ui.min.js') }}"></script>

        <script>
            var groupCount = {{ $spectype->specificationGroups->unique()->count() }};
            var specificationCount = {{ $spectype->specifications->unique()->count() }};
        </script>

        <script src="{{ asset('back/assets/js/pages/spectypes/edit.js') }}"></script>
@endpush