<script id="files-template" type="text/x-custom-template">
    <div class="row single-file animated fadeIn">
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label>عنوان فایل</label>
                <input type="text" class="form-control" name="title" required>
            </div>
        </div>

        <div class="col-md-6">
            <fieldset class="form-group">
                <label>انتخاب فایل</label>
                <div class="custom-file">
                    <input id="file" type="file" name="file" class="custom-file-input" required>
                    <label class="custom-file-label" for="file"></label>
                </div>
            </fieldset>
        </div>

        <div class="col-md-3 col-12">
            <div class="form-group">
                <label>قیمت</label>
                <input type="number" class="form-control amount-input" name="price" min="0" required>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="form-group">
                <label>تخفیف</label>
                <input type="number" step="any" class="form-control" name="discount" min="0" max="100">
            </div>
        </div>

        <div class="col-md-3 col-12">
            <div class="form-group">
                <label>وضعیت</label>
                <select name="status" class="form-control">
                    <option value="active">فعال</option>
                    <option value="inactive">غیر فعال</option>
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <button type="button" class="btn btn-flat-danger waves-effect waves-light remove-file custom-padding">حذف</button>
            <hr>
        </div>
    </div>
</script>
