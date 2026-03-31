<script id="specification-group" type="text/x-custom-template">
    <div class="row mt-2 animated flipInX specification-group">
        <div class="col-4">
            <div class="form-group">
                <label>نام گروه</label>
                <input type="text" class="form-control group-input"  name="specification_group" placeholder="مثال: مشخصات کلی" required>
            </div>
        </div>

        <div class="all-specifications col-12"></div>
        
        <div class="col-md-12 text-center">
            <button type="button" class="btn btn-flat-success waves-effect waves-light add-specifaction">افزودن مشخصات</button>
            <button type="button" class="btn btn-flat-danger waves-effect waves-light remove-group">حذف گروه</button>

        </div>
    </div>
</script>

<script id="specification-single" type="text/x-custom-template">
    <div class="single-specificition animated flipInX">
        <div class="row">
            
            <div class="col-md-4 form-group">
                <p class="spec-label">عنوان</p>
                <input type="text" class="form-control spec-label" name="specification_name" placeholder="مثال: حافظه داخلی" required>
            </div>
            
            <div class="col-md-1">
                <button type="button" class="btn btn-flat-danger waves-effect waves-light remove-specification custom-padding"><i class="feather icon-minus"></i></button>
            </div>
        </div>
    </div>
</script>