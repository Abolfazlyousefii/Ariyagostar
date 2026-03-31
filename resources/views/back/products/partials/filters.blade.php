<div class="card">
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
                <form id="filter-comments-form" method="GET" action="{{ $filter_action }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label>عنوان</label>
                            <fieldset class="form-group">
                                <input class="form-control" name="title" value="{{ request('title') }}">
                            </fieldset>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label>دسته بندی ها</label>
                                <select class="form-control product-category" name="category_id[]" multiple>
                                    @foreach ($categories as $category)
                                        <option class="l{{ $category->parents()->count() + 1 }} {{ $category->categories()->count() ? 'non-leaf' : '' }}" data-pup="{{ $category->category_id }}" {{ request()->input('category_id') && in_array($category->id, request()->input('category_id')) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                            <label>مرتب سازی</label>
                            <fieldset class="form-group">
                                <select class="form-control" name="ordering">
                                    <option value="latest" {{ request('ordering') == 'latest' ? 'selected' : '' }}>
                                        جدیدترین
                                    </option>
                                    <option value="oldest" {{ request('ordering') == 'oldest' ? 'selected' : '' }}>
                                        قدیمی ترین
                                    </option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-3">
                            <label>تعداد در صفحه</label>
                            <fieldset class="form-group">
                                <select class="form-control" name="paginate">
                                    <option value="10" {{ request('paginate') == '10' ? 'selected' : '' }}>
                                        10
                                    </option>
                                    <option value="20" {{ request('paginate') == '20' ? 'selected' : '' }}>
                                        20
                                    </option>
                                    <option value="50" {{ request('paginate') == '50' ? 'selected' : '' }}>
                                        50
                                    </option>
                                    <option value="all" {{ request('paginate') == 'all' ? 'selected' : '' }}>
                                        همه
                                    </option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-3">
                            <label>وضعیت موجودی</label>
                            <fieldset class="form-group">
                                <select class="form-control" name="stock">
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
                        <div class="col-md-3">
                            <label>وضعیت انتشار</label>
                            <fieldset class="form-group">
                                <select class="form-control" name="published">
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

                    </div>
                    <div class="row">
                        <div class="col-6">
                            <fieldset class="checkbox">
                                <div class="vs-checkbox-con vs-checkbox-primary">
                                    <input type="checkbox" name="special" {{ request('special') ? 'checked' : '' }}>
                                    <span class="vs-checkbox">
                                        <span class="vs-checkbox--check">
                                            <i class="vs-icon feather icon-check"></i>
                                        </span>
                                    </span>
                                    <span>فقط ویژه ها؟</span>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-outline-success square  mb-1 waves-effect waves-light">
                                فیلتر کردن
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
