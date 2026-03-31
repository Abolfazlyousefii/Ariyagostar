<div class="modal fade" id="add-filterable-modal" tabindex="-1" role="dialog" aria-labelledby="add-filterable-modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">افزودن مشخصات</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input id="search-filterable-input" type="text" class="form-control" name="search-filterable" placeholder="جستجوی مشخصات...">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($static_filters as $static_filter)
                            <div class="col-md-4 mb-1 filterable-area" data-name="{{ $static_filter->title }}" data-id="{{ $static_filter->id }}" data-type="static_filter" data-title="فیلتر ثابت">
                                <div class="row">
                                    <div class="col-9 filterable-name">
                                        <b>{{ $static_filter->title }} <small class="text-warning">( فیلتر ثابت )</small></b>
                                    </div>
                                    <div class="col-3 text-right">
                                        <button type="button" class="btn btn-success waves-effect waves-light filterable-plus" data-dismiss="modal">افزودن</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        @foreach ($attributeGroups as $attributeGroup)
                            <div class="col-md-4 mb-1 filterable-area" data-name="{{ $attributeGroup->name }}" data-id="{{ $attributeGroup->id }}" data-type="attributeGroup" data-title="گروه ویژگی">
                                <div class="row">
                                    <div class="col-9 filterable-name">
                                        <b>{{ $attributeGroup->name }} <small class="text-warning">( گروه ویژگی )</small></b>
                                    </div>
                                    <div class="col-3 text-right">
                                        <button type="button" class="btn btn-success waves-effect waves-light filterable-plus" data-dismiss="modal">افزودن</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">

                        @foreach ($specifications as $specification)
                            <div class="col-md-4 mb-1 filterable-area" data-name="{{ $specification->name }}" data-id="{{ $specification->id }}" data-type="specification" data-title="مشخصات">
                                <div class="row">
                                    <div class="col-9 filterable-name">
                                        <b>{{ $specification->name }} <small class="text-warning">( مشخصات )</small></b>
                                    </div>
                                    <div class="col-3 text-right">
                                        <button type="button" class="btn btn-success waves-effect waves-light filterable-plus" data-dismiss="modal">افزودن</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>