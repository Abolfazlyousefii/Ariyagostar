@foreach ($spec_type->specificationGroups->unique() as $group)
    <div class="row mt-2 specification-group">
        <div class="col-12">
            <div class="row group-row">
                <div class="col-md-1">
                    <span>نام گروه</span>
                </div>
                <div class="col-md-10 form-group">
                    <input type="text" class="form-control group-input" data-group_name="{{ $loop->index }}" name="specification_group[{{ $loop->index }}][name]" placeholder="مثال: مشخصات کلی" value="{{ $group->name }}" required>
                </div>
            </div>
        </div>

        <div class="all-specifications col-12">
            @foreach($spec_type->specifications()->where('specification_group_id', $group->id)->get() as $specification)
                <div class="single-specificition">
                    <div class="row">
                        <div class="col-md-1">
                            <fieldset>
                                <label>
                                    <input name="specification_group[{{ $loop->parent->index }}][specifications][{{ $loop->index }}][special]" type="checkbox">
                                </label>
                            </fieldset>
                        </div>
                        <div class="col-md-4 form-group">
                            <p class="spec-label">عنوان</p>
                            <input type="text" class="form-control spec-label" name="specification_group[{{ $loop->parent->index }}][specifications][{{ $loop->index }}][name]" placeholder="مثال: حافظه داخلی" value="{{ $specification->name }}" required>
                        </div>
                        
                        <div class="col-md-6 form-group">
                            <p class="spec-label">مقدار</p>
                            <textarea  class="form-control spec-label" rows="1" name="specification_group[{{ $loop->parent->index }}][specifications][{{ $loop->index }}][value]" placeholder="مثال: 32 گیگابایت" required></textarea>
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