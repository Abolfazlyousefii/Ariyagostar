<form id="filter-products-form" method="GET" action="{{ $filter_action }}">
    <div class="card mb-1">
        <div class="card-header filter-card">
            <h4 class="card-title">فیلتر کردن</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse {{ request()->except('page') ? 'show' : '' }}">
            <div class="card-body">
                <div class="users-list-filter">

                    <div class="row">
                        <div class="col-md-4">
                            <label>عنوان</label>
                            <fieldset class="form-group">
                                <input class="form-control datatable-filter" name="title" value="{{ request('title') }}">
                            </fieldset>
                        </div>
                        <div class="col-md-2">
                            <label>برند</label>
                            <fieldset class="form-group">
                                <select class="form-control datatable-filter select2" name="brand_id">
                                    <option value="all" {{ request('brand_id') == 'all' ? 'selected' : '' }}>
                                        همه
                                    </option>
                                    <option value="none" {{ request('brand_id') == 'none' ? 'selected' : '' }}>
                                        انتخاب نشده
                                    </option>

                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-md-2">
                            <label>نوع مشخصات</label>
                            <fieldset class="form-group">
                                <select class="form-control datatable-filter select2" name="spec_type_id">
                                    <option value="all" {{ request('spec_type_id') == 'all' ? 'selected' : '' }}>
                                        همه
                                    </option>
                                    <option value="none" {{ request('spec_type_id') == 'none' ? 'selected' : '' }}>
                                        انتخاب نشده
                                    </option>

                                    @foreach ($specTypes as $specType)
                                        <option value="{{ $specType->id }}" {{ request('spec_type_id') == $specType->id ? 'selected' : '' }}>
                                            {{ $specType->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-md-2">
                            <label>وضعیت موجودی</label>
                            <fieldset class="form-group">
                                <select class="form-control datatable-filter" name="stock">
                                    <option value="all" {{ request('stock') == 'all' ? 'selected' : '' }}>
                                        همه
                                    </option>
                                    <option value="available" {{ request('stock') == 'available' ? 'selected' : '' }}>
                                        موجود
                                    </option>
                                    <option value="unavailable" {{ request('stock') == 'unavailable' ? 'selected' : '' }}>
                                        ناموجود
                                    </option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-2">
                            <label>وضعیت تخفیف</label>
                            <fieldset class="form-group">
                                <select class="form-control datatable-filter" name="discount">
                                    <option value="all" {{ request('discount') == 'all' ? 'selected' : '' }}>
                                        همه
                                    </option>
                                    <option value="yes" {{ request('discount') == 'yes' ? 'selected' : '' }}>
                                        تخفیف دار
                                    </option>
                                    <option value="no" {{ request('discount') == 'no' ? 'selected' : '' }}>
                                        بدون تخفیف
                                    </option>
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-md-2">
                            <label>وضعیت انتشار</label>
                            <fieldset class="form-group">
                                <select class="form-control datatable-filter" name="published">
                                    <option value="all" {{ request('published') == 'all' ? 'selected' : '' }}>
                                        همه
                                    </option>
                                    <option value="yes" {{ request('published') == 'yes' ? 'selected' : '' }}>
                                        منتشر شده
                                    </option>
                                    <option value="no" {{ request('published') == 'no' ? 'selected' : '' }}>
                                        پیش نویس
                                    </option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-2">
                            <label>محصول ویژه</label>
                            <fieldset class="form-group">
                                <select class="form-control datatable-filter" name="special">
                                    <option value="all" {{ request('special') == 'all' ? 'selected' : '' }}>
                                        همه
                                    </option>
                                    <option value="yes" {{ request('special') == 'yes' ? 'selected' : '' }}>
                                        بله
                                    </option>
                                    <option value="no" {{ request('special') == 'no' ? 'selected' : '' }}>
                                        خیر
                                    </option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-2">
                            <label>لینک ترب</label>
                            <fieldset class="form-group">
                                <select class="form-control datatable-filter" name="torob_link">
                                    <option value="all" {{ request('torob_link') == 'all' ? 'selected' : '' }}>
                                        همه
                                    </option>
                                    <option value="yes" {{ request('torob_link') == 'yes' ? 'selected' : '' }}>
                                        موجود باشد
                                    </option>
                                    <option value="no" {{ request('torob_link') == 'no' ? 'selected' : '' }}>
                                        موجود نباشد
                                    </option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-3 d-none">
                            <label>نوع محصول</label>
                            <fieldset class="form-group">
                                <select class="form-control datatable-filter" name="type">
                                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>
                                        همه
                                    </option>
                                    <option value="physical" {{ request('type') == 'physical' ? 'selected' : '' }}>
                                        فیزیکی
                                    </option>
                                    <option value="download" {{ request('type') == 'download' ? 'selected' : '' }}>
                                        دانلودی
                                    </option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-2">
                            <label>آیدی محصول</label>
                            <fieldset class="form-group">
                                <input name="id" type="text" class="form-control datatable-filter" value="{{ request()->id }}">
                            </fieldset>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>دسته بندی ها</label>
                                <select class="form-control datatable-filter product-category" name="category_id[]" multiple>
                                    <option class="l1 " data-pup="" {{ request()->input('category_id') && in_array('no_category', request()->input('category_id')) ? 'selected' : '' }} value="no_category">بدون دسته بندی</option>
                                    @foreach ($categories as $category)
                                        <option class="l{{ $category->parents()->count() + 1 }} {{ $category->categories()->count() ? 'non-leaf' : '' }}" data-pup="{{ $category->category_id }}" {{ request()->input('category_id') && in_array($category->id, request()->input('category_id')) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>توضیحات</label>
                            <fieldset class="form-group">
                                <input class="form-control datatable-filter" name="description" value="{{ request('description') }}">
                            </fieldset>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</form>
