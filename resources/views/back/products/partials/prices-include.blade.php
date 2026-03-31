<div class="row single-price">

    <div class="col-12">
        <div class="row">
            @foreach ($attributeGroups as $attributeGroup)
                <div class="col-md-3 col-12">
                    <div class="form-group">
                        <label>{{ $attributeGroup->name }}</label>
                        <select class="form-control price-attribute-select select2" data-type="{{ $attributeGroup->type }}" data-number="{{ $loop->parent->iteration }}" name="prices[{{ $loop->parent->iteration }}][attributes][]">
                            <option value="">انتخاب کنید</option>
                            @foreach ($attributeGroup->get_attributes->sortBy('name')->sortBy('ordering') as $attribute)
                                <option value="{{ $attribute->id }}" {{ $price->get_attributes->find($attribute->id) ? 'selected' : '' }}>{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endforeach

            <input type="hidden" data-number="{{ $loop->iteration }}" value="{{ $price->image->image ?? '' }}" class="price-image" name="prices[{{ $loop->iteration }}][image]">
        </div>
    </div>

    <div class="col-md-3 col-12">
        <div class="form-group">
            <label>قیمت</label>
            <input type="number" data-unit="تومان" class="form-control amount-input price" name="prices[{{ $loop->iteration }}][price]" value="{{ $price->price() }}" required>
        </div>
    </div>

    <div class="col-md-3 col-12">
        <div class="form-group">
            <label>تخفیف</label>
            <input type="number" class="form-control discount" name="prices[{{ $loop->iteration }}][discount]" value="{{ $price->discount }}" min="0" max="100" placeholder="%">
        </div>
    </div>
    <div class="col-md-3 col-12">
        <div class="form-group">
            <label>زمان انقضای تخفیف</label>
            <input type="text" class="form-control discount_expire_at persian-date-picker" data-timestamps="true" name="prices[{{ $loop->iteration }}][discount_expire_at]" value="{{ $price->discount_expire_at ? jdate($price->discount_expire_at)->getTimestamp() : '' }}">
        </div>
    </div>

    <div class="col-md-3 col-12">
        <div class="form-group">
            <label>بیشترین تعداد مجاز در هر سفارش</label>
            <input type="number" class="form-control cart_max" name="prices[{{ $loop->iteration }}][cart_max]" value="{{ $price->cart_max }}" min="1">
        </div>
    </div>
    <div class="col-md-3 col-12">
        <div class="form-group">
            <label>کمترین تعداد مجاز در هر سفارش</label>
            <input type="number" class="form-control cart_min" name="prices[{{ $loop->iteration }}][cart_min]" value="{{ $price->cart_min }}" min="1">
        </div>
    </div>
    <div class="col-md-3 col-12">
        <div class="form-group">
            <label>موجودی انبار</label>
            <input type="number" class="form-control stock" name="prices[{{ $loop->iteration }}][stock]" value="{{ $price->stock }}" min="0" required>
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
