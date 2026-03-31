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
                                    <li class="breadcrumb-item active">لیست ویژگی ها
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        <div id="save-changes" class="spinner-border text-success" role="status" style="display: none">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body" id="main-card">
                @if($attributeGroups->count())
                    <section class="card attributeGroups-sortable">
                        <div class="card-header">
                            <h4 class="card-title">لیست ویژگی ها</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ردیف</th>
                                                <th>عنوان</th>
                                                <th class="text-center">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody id="attributeGroups-sortable">
                                            @foreach($attributeGroups as $attributeGroup)
                                                <tr id="attributeGroup-{{ $attributeGroup->id }}">
                                                    <td class="text-center draggable-handler">
                                                        <div class="fonticon-wrap"><i class="feather icon-move"></i></div>
                                                    </td>
                                                    
                                                    <td>{{ $attributeGroup->name }}</td>

                                                    <td class="text-center">

                                                        @can('attributes.index')
                                                            <a href="{{ route('admin.attributes.index', ['attributeGroup' => $attributeGroup]) }}" class="btn btn-success mr-1 waves-effect waves-light">مشاهده مقادیر</a>
                                                        @endcan

                                                        @can('attributes.groups.update')
                                                            <a href="{{ route('admin.attributeGroups.edit', ['attributeGroup' => $attributeGroup]) }}" class="btn btn-info mr-1 waves-effect waves-light">ویرایش</a>
                                                        @endcan

                                                        @can('attributes.groups.delete')
                                                            <button type="button" data-attributegroup="{{ $attributeGroup->id }}" class="btn btn-danger mr-1 waves-effect waves-light btn-delete"  data-toggle="modal" data-target="#delete-modal">حذف</button>
                                                        @endcan
                                                        
                                                    </td>
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
                            <h4 class="card-title">لیست ویژگی ها</h4>
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

    {{-- delete attributeGroup modal --}}
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
                    با حذف ویژگی  دیگر قادر به بازیابی آن نخواهید بود
                </div>
                <div class="modal-footer">
                    <form action="#" id="attributeGroup-delete-form">
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
    <script src="{{ asset('back/app-assets/plugins/jquery-ui-sortable/jquery-ui.min.js') }}"></script>  
    
    <!-- Page Js codes -->
    <script src="{{ asset('back/assets/js/pages/attributeGroups/index.js') }}"></script>
@endpush
