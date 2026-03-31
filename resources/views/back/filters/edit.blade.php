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
                                    <li class="breadcrumb-item">مدیریت فیلتر ها
                                    </li>
                                    <li class="breadcrumb-item active">ویرایش فیلتر
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
                        <h4 class="card-title">ویرایش فیلتر </h4>
                    </div>
                    
                    <div id="main-card" class="card-content">
                        <div class="card-body">
                            <div class="col-12 col-md-12">
                                <form class="form" id="filter-edit-form" action="{{ route('admin.filters.update', ['filter' => $filter]) }}">
                                    @csrf
                                    @method('put')
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="title" placeholder="عنوان فیلتر" value="{{ $filter->title }}">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group float-right">
                                                    <button type="button" data-toggle="modal" data-target="#add-filterable-modal" type="submit" class="btn btn-success mb-1 waves-effect waves-light"><i class="fa fa-plus"></i> افزودن فیلتر جدید</button>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="filters-table" class="table table-striped mb-0">
                                                        <thead>
                                                        <tr>
                                                            <th style="width: 20px;"></th>
                                                            <th class="text-center" style="width: 300px;">عنوان</th>
                                                            <th class="text-center">وضعیت</th>
                                                            <th class="text-center">اطلاعات اضافی</th>
                                                            <th class="text-center">عملیات</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                            @include('back.filters.partials.filterables')    
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-2">

                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mb-1 waves-effect waves-light">ویرایش فیلتر</button>
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

    <!-- add filterable Modal -->
    @include('back.filters.partials.filterable-modal')
    <!-- End add filterable Modal -->

    @include('back.filters.partials.filterable-tr-template')

@endsection

@push('scripts') 
    <script>
        var filtersCount = {{ $filter->related->count() }};
    </script>

    <script src="{{ asset('back/app-assets/plugins/jquery-ui-sortable/jquery-ui.min.js') }}"></script>  
    <script src="{{ asset('back/app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('back/app-assets/plugins/jquery-validation/localization/messages_fa.min.js') }}"></script>

    <script src="{{ asset('back/assets/js/pages/filters/edit.js') }}"></script>
    <script src="{{ asset('back/assets/js/pages/filters/all.js') }}"></script>
@endpush