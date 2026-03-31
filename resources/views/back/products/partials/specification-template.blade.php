<div class="modal fade text-left" id="specifications-modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                آیا میخواهید گروه های این نوع مشخصات اضافه شوند؟ <br>
                با اینکار مشخصات وارد شده فعلی حذف خواهند شد
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">خیر</button>
                <button id="add-spec-type-data" type="button" class="btn btn-danger waves-effect waves-light"  data-dismiss="modal">بله اضافه شود</button>
            </div>
        </div>
    </div>
</div>

<script id="specification-group" type="text/x-custom-template">
    <div class="row mt-2 animated fadeIn specification-group">
        <div class="col-12">
            <div class="row group-row">
                <div class="col-md-1">
                    <span>نام گروه</span>
                </div>
                <div class="col-md-10 form-group">
                    <input type="text" class="form-control group-input" name="specification_group" placeholder="مثال: مشخصات کلی" required>
                </div>
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
    <div class="single-specificition animated fadeIn">
        <div class="row">
            <div class="col-md-1">
                <fieldset>
                    <label>
                        <input name="special_specification" type="checkbox">
                    </label>
                </fieldset>
            </div>
            <div class="col-md-4 form-group">
                <p class="spec-label">عنوان</p>
                <input type="text" class="form-control spec-label" name="specification_name" placeholder="مثال: حافظه داخلی" required>
            </div>
            
            <div class="col-md-6 form-group">
                <p class="spec-label">مقدار</p>
                <textarea  class="form-control spec-label" rows="1" name="specification_value" placeholder="مثال: 32 گیگابایت" required></textarea>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-flat-danger waves-effect waves-light remove-specification custom-padding"><i class="feather icon-minus"></i></button>
            </div>
        </div>
    </div>
</script>