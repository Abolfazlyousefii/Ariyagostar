<script id="prices-template" type="text/x-custom-template">
    <div class="row animated fadeIn single-price">

        <div class="col-12">
            <div class="row">
                @foreach ($attributeGroups as $attributeGroup)
                    <div class="col-md-3 col-12">
                        <div class="form-group">
                            <label>{{ $attributeGroup->name }}</label>
                            <select class="form-control price-attribute-select select2" data-type="{{ $attributeGroup->type }}" name="attribute">
                                <option value="">انتخاب کنید</option>
                                @foreach ($attributeGroup->get_attributes()->orderBy('ordering')->orderBy('name')->get() as $attribute)
                                    <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endforeach

                <input type="hidden" class="price-image" name="price_image">
            </div>
        </div>

        <div class="col-md-3 col-12">
            <div class="form-group">
                <label>قیمت</label>
                <input type="number" data-unit="تومان" class="form-control amount-input price" name="price" required>
            </div>
        </div>

        <div class="col-md-3 col-12">
            <div class="form-group">
                <label>تخفیف</label>
                <input type="number" class="form-control discount" name="discount" min="0" max="100" placeholder="%">
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="form-group">
                <label>زمان انقضای تخفیف</label>
                <input type="text" class="form-control discount_expire_at persian-date-picker" data-timestamps="true" name="discount_expire_at">
            </div>
        </div>

        <div class="col-md-3 col-12">
            <div class="form-group">
                <label>بیشترین تعداد مجاز در هر سفارش</label>
                <input type="number" class="form-control cart_max" name="cart_max" min="1">
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="form-group">
                <label>کمترین تعداد مجاز در هر سفارش</label>
                <input type="number" class="form-control cart_min" name="cart_min" min="1">
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="form-group">
                <label>موجودی انبار</label>
                <input type="number" class="form-control stock" name="stock" min="0" required>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="form-group">
                <label>قیمت نهایی</label>
                <input type="text" class="form-control final-price" disabled>
            </div>
        </div>

        <div class="col-md-12">
            <button type="button" class="btn btn-flat-danger waves-effect waves-light remove-product-price custom-padding">حذف</i></button>
        </div>

        <div class="col-md-12"><hr></div>
    </div>
</script>
