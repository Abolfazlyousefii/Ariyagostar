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
                                    <li class="breadcrumb-item">مدیریت محصولات
                                    </li>
                                    <li class="breadcrumb-item active">ویرایش محصول
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div id="main-card" class="content-body">
                <form class="form" id="product-edit-form" action="{{ route('admin.products.update', ['product' => $product]) }}" data-redirect="{{ route('admin.products.index') }}" method="post">
                    @csrf
                    @method('put')

                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card overflow-hidden">
                                <div class="card-header">
                                    <h4 class="card-title">اطلاعات محصول "{{ $product->title }}"</h4>
                                    <a target="_blank" href="{{ $product->link() }}" class="btn btn-success">مشاهده محصول</a>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">

                                        <div class="nav-vertical">
                                            <ul class="nav nav-tabs nav-left flex-column" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="baseVerticalLeft-tab1" data-toggle="tab" aria-controls="tabVerticalLeft1" href="#tabVerticalLeft1" role="tab" aria-selected="true">اطلاعات کلی</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="productMetaTab" data-toggle="tab" aria-controls="tabProductMeta" href="#tabProductMeta" role="tab" aria-selected="false">سئو</a>
                                                </li>
                                                <li class="nav-item physical-item">
                                                    <a class="nav-link" id="product-prices-tab-nav" data-toggle="tab" aria-controls="product-prices-tab" href="#product-prices-tab" role="tab" aria-selected="false">قیمت</a>
                                                </li>
                                                <li class="nav-item download-item">
                                                    <a class="nav-link" id="product-files-tab-nav" data-toggle="tab" aria-controls="product-files-tab" href="#product-files-tab" role="tab" aria-selected="false">فایل</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="productImageTab" data-toggle="tab" aria-controls="tabProductImage" href="#tabProductImage" role="tab" aria-selected="false">تصاویر</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="specification-tab" data-toggle="tab" aria-controls="tabSpecification" href="#tabSpecification" role="tab" aria-selected="false">مشخصات</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="torob-tab" data-toggle="tab" aria-controls="tabTorob" href="#tabTorob" role="tab" aria-selected="false">ترب</a>
                                                </li>
                                                <li class="nav-item physical-item">
                                                    <a class="nav-link" id="sizes-tab" data-toggle="tab" aria-controls="tabSize" href="#tabSize" role="tab" aria-selected="false">سایز بندی</a>
                                                </li>

                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tabVerticalLeft1" role="tabpanel" aria-labelledby="baseVerticalLeft-tab1">
                                                    <div class="col-md-12">
                                                        <div class="form-body">

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>عنوان</label>
                                                                        <input type="text" class="form-control" name="title" value="{{ $product->title }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>عنوان انگلیسی</label>
                                                                        <input type="text" class="form-control" name="title_en" value="{{ $product->title_en }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>دسته بندی اصلی</label>
                                                                        <select class="form-control product-category" name="category_id">
                                                                            <option value="">انتخاب کنید</option>
                                                                            @foreach ($categories as $category)
                                                                                <option class="l{{ $category->parents()->count() + 1 }} {{ $category->categories()->count() ? 'non-leaf' : '' }}" data-pup="{{ $category->category_id }}" {{ $product->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group">
                                                                        <label>نوع محصول</label>
                                                                        <select name="type" id="product-type" class="form-control">
                                                                            <option value="physical" {{ $product->isPhysical() ? 'selected' : '' }}>محصول فیزیکی</option>
                                                                            <option value="download" {{ $product->isDownload() ? 'selected' : '' }}>محصول دانلودی</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3 col-12 physical-item">
                                                                    <div class="form-group">
                                                                        <label>برند</label>
                                                                        <input id="brand" type="text" class="form-control" name="brand" value="{{ $product->brand ? $product->brand->name : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-12 physical-item">
                                                                    <div class="form-group">
                                                                        <label>وزن (گرم)</label>
                                                                        <input type="number" class="form-control" name="weight" value="{{ $product->weight }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-12 physical-item">
                                                                    <div class="form-group">
                                                                        <label>واحد</label>
                                                                        <input type="text" class="form-control" name="unit" value="{{ $product->unit }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>دسته بندی ها</label>
                                                                        <select class="form-control product-categories" name="categories[]" multiple>
                                                                            @foreach ($categories as $category)
                                                                                <option class="l{{ $category->parents()->count() + 1 }} {{ $category->categories()->count() ? 'non-leaf' : '' }}" data-pup="{{ $category->category_id }}" {{ $product->categories()->find($category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <fieldset class="form-group">
                                                                        <label>برچسب</label>
                                                                        <input type="text" name="labels" class="form-control labels" data-action="{{ route('admin.get-labels') }}" value="{{ $product->getLabels() }}">
                                                                    </fieldset>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>توضیحات کوتاه</label>
                                                                        <textarea class="form-control" name="short_description" rows="4">{{ $product->short_description }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="first-name-vertical">توضیحات</label>
                                                                        <textarea id="description" class="form-control" rows="3" name="description">{{ $product->description }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="product-prices-tab" role="tabpanel" aria-labelledby="product-prices-tab-nav">

                                                    <div class="card collapse-icon accordion-icon-rotate product-prices-tab">

                                                        <div class="card-body">

                                                            <div class="row prices-option-div">

                                                                <div class="col-md-3 col-12">
                                                                    <div class="form-group">
                                                                        <label>انتخاب ارز</label>
                                                                        <select name="currency_id" class="form-control">
                                                                            <option data-amount="1" data-title="تومان" value="">تومان (پیش فرض)</option>
                                                                            @foreach ($currencies as $currency)
                                                                                <option data-amount="{{ $currency->amount }}" data-title="{{ $currency->title }}" value="{{ $currency->id }}" {{ $product->currency && $product->currency->id == $currency->id ? 'selected' : '' }}>{{ $currency->title }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 col-12">
                                                                    <div class="form-group">
                                                                        <label>گرد کردن</label>
                                                                        <select name="rounding_amount" class="form-control">
                                                                            <option data-value="{{ option('default_rounding_amount', 'no') }}" value="default" {{ $product->rounding_amount == 'default' ? 'selected' : '' }}>پیشفرض</option>
                                                                            <option data-value="no" value="no" {{ $product->rounding_amount == 'no' ? 'selected' : '' }}>خیر</option>
                                                                            <option data-value="100" value="100" {{ $product->rounding_amount == '100' ? 'selected' : '' }}>100 تومان</option>
                                                                            <option data-value="1000" value="1000" {{ $product->rounding_amount == '1000' ? 'selected' : '' }}>1000 تومان</option>
                                                                            <option data-value="10000" value="10000" {{ $product->rounding_amount == '10000' ? 'selected' : '' }}>10000 تومان</option>
                                                                            <option data-value="100000" value="100000" {{ $product->rounding_amount == '100000' ? 'selected' : '' }}>100000 تومان</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>نحوه گرد کردن</label>
                                                                        <select name="rounding_type" class="form-control">
                                                                            <option data-value="{{ option('default_rounding_type', 'close') }}" value="default" {{ $product->rounding_type == 'default' ? 'selected' : '' }}>پیشفرض</option>
                                                                            <option data-value="close" value="close" {{ $product->rounding_type == 'close' ? 'selected' : '' }}>نزدیک</option>
                                                                            <option data-value="up" value="up" {{ $product->rounding_type == 'up' ? 'selected' : '' }}>رو به بالا</option>
                                                                            <option data-value="down" value="down" {{ $product->rounding_type == 'down' ? 'selected' : '' }}>رو به پایین</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <hr>
                                                                </div>
                                                            </div>

                                                            <div id="product-prices-div" class="product-prices-div">
                                                                @if ($product->isPhysical())
                                                                    @foreach ($product->prices as $price)
                                                                        @include('back.products.partials.prices-include', ['price' => $price])
                                                                    @endforeach
                                                                @endif
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-12 text-center mt-2">
                                                                    <button id="add-product-prices" type="button" class="btn btn-outline-primary waves-effect waves-light"><i class="feather icon-plus"></i> افزودن قیمت</button>
                                                                    <button id="copy-product-prices" type="button" class="btn btn-outline-primary waves-effect waves-light"><i class="feather icon-copy"></i> کپی آخرین قیمت</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="tab-pane" id="product-files-tab" role="tabpanel" aria-labelledby="product-files-tab-nav">

                                                    <div class="col-md-12">
                                                        <div id="product-files-area">
                                                            @if ($product->isDownload())
                                                                @foreach ($product->prices()->orderBy('ordering')->get() as $price)
                                                                    @include('back.products.partials.files-include', ['price' => $price])
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 text-center mt-2">
                                                                <button id="add-product-file" type="button" class="btn btn-outline-primary waves-effect waves-light"><i class="feather icon-plus"></i> افزودن فایل</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="tab-pane" id="tabSpecification" role="tabpanel" aria-labelledby="specification-tab">
                                                    <div id="specifications-card" class="card">
                                                        <div class="card-header d-flex justify-content-between align-items-end">
                                                            <h4 class="card-title">مشخصات محصول</h4>
                                                            <p class="font-medium-5 mb-0"><i class="feather icon-help-circle text-muted cursor-pointer"></i></p>
                                                        </div>
                                                        <div class="card-content">
                                                            <div class="card-body ">
                                                                <div class="row">
                                                                    <div class="col-md-7 text-justify">
                                                                        <p>در این بخش میتوانید مشخصات محصول را وارد کنید. دقت کنید که محصولات بر اساس نوع مشخصات با یکدیگر مقایسه میشوند. به عنوان مثال یک محصول با نوع مشخصات "گوشی موبایل" فقط با محصولات این نوع مقایسه میشود</p>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>نوع مشخصات</label>
                                                                            <input id="specifications_type" class="form-control" name="spec_type" placeholder="مثلا گوشی موبایل" value="{{ $product->specType ? $product->specType->name : '' }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-body pt-2">
                                                                    <div id="specifications-area">
                                                                        @foreach ($product->specificationGroups->unique() as $group)
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
                                                                                    @foreach ($product->specifications()->where('specification_group_id', $group->id)->get() as $specification)
                                                                                        <div class="single-specificition">
                                                                                            <div class="row">
                                                                                                <div class="col-md-1">
                                                                                                    <fieldset>
                                                                                                        <label>
                                                                                                            <input name="specification_group[{{ $loop->parent->index }}][specifications][{{ $loop->index }}][special]" type="checkbox" {{ $specification->pivot->special ? 'checked' : '' }}>
                                                                                                        </label>
                                                                                                    </fieldset>
                                                                                                </div>
                                                                                                <div class="col-md-4 form-group">
                                                                                                    <p class="spec-label">عنوان</p>
                                                                                                    <input type="text" class="form-control spec-label" name="specification_group[{{ $loop->parent->index }}][specifications][{{ $loop->index }}][name]" placeholder="مثال: حافظه داخلی" value="{{ $specification->name }}" required>
                                                                                                </div>

                                                                                                <div class="col-md-6 form-group">
                                                                                                    <p class="spec-label">مقدار</p>
                                                                                                    <textarea class="form-control spec-label" rows="1" name="specification_group[{{ $loop->parent->index }}][specifications][{{ $loop->index }}][value]" placeholder="مثال: 32 گیگابایت" required>{{ $specification->pivot->value }}</textarea>
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
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-12 text-center mt-4">
                                                                            <button id="add-product-specification-group" type="button" class="btn btn-outline-primary waves-effect waves-light"><i class="feather icon-plus"></i> افزودن گروه مشخصات</button>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="tabProductMeta" role="tabpanel" aria-labelledby="productMetaTab">
                                                    <div class="col-md-12">
                                                        <div class="form-body">

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>عنوان سئو</label>
                                                                        <input type="text" class="form-control" name="meta_title" value="{{ $product->meta_title }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>url</label>
                                                                        <input id="slug" type="text" class="form-control" name="slug" value="{{ $product->slug }}">
                                                                        <p>
                                                                            <small>
                                                                                <a id="generate-product-slug" href="#">ایجاد خودکار</a>
                                                                                <span id="slug-spinner" class="spinner-grow spinner-grow-sm text-success" role="status" style="display: none;">
                                                                                    <span class="sr-only">Loading...</span>
                                                                                </span>
                                                                            </small>
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>توضیحات سئو</label>
                                                                        <textarea class="form-control" name="meta_description" rows="3">{{ $product->meta_description }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <fieldset class="form-group">
                                                                        <label>کلمات کلیدی</label>
                                                                        <input type="text" name="tags" class="form-control tags" data-action="{{ route('admin.get-tags') }}" value="{{ $product->getTags }}">
                                                                    </fieldset>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                @include('back.products.partials.sizes-tab')

                                                @include('back.products.partials.torob-tab')

                                                <div class="tab-pane overflow-hidden" id="tabProductImage" role="tabpanel" aria-labelledby="productImageTab">
                                                    <div class="col-md-12">
                                                        <div class="form-body">

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>تصاویر محصول ( <small>بهترین اندازه <span class="text-danger">{{ config('front.imageSizes.productGalleryImage') }}</span> پیکسل میباشد.</small> )</label>

                                                                    <div class="dropzone dropzone-area mb-2" id="product-images">
                                                                        <div class="dz-message">تصاویر را به اینجا بکشید</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <fieldset class="form-group">
                                                                        <label>تصویر شاخص</label>
                                                                        <div class="custom-file">
                                                                            <input id="image" type="file" accept="image/*" name="image" class="custom-file-input">
                                                                            <label class="custom-file-label" for="image">{{ $product->image }}</label>
                                                                            <p><small>بهترین اندازه <span class="text-danger">{{ config('front.imageSizes.productImage') }}</span> پیکسل میباشد.</small></p>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>متن جایگزین تصویر</label>
                                                                        <input type="text" class="form-control" name="image_alt" value="{{ $product->image_alt }}">
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card">

                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-body">

                                    <div class="row">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label>تاریخ ایجاد</label>
                                                <input autocomplete="off" type="text" data-timestamps="true" class="form-control persian-date-picker ltr" name="created_at" value="{{ jdate($product->created_at)->getTimestamp() }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label>تاریخ انتشار</label>
                                                <input id="publish_date" autocomplete="off" type="text" data-timestamps="true" class="form-control persian-date-picker ltr" name="publish_date" value="{{ $product->publish_date ? jdate($product->publish_date)->getTimestamp() : jdate($product->created_at)->getTimestamp() }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <ul class="list-unstyled mb-0 mt-3">
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" name="published" id="customRadio1" value="1" {{ $product->published ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="customRadio1">انتشار</label>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2">
                                                    <fieldset>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" name="published" id="customRadio2" value="0" {{ !$product->published ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="customRadio2">پیش نویس</label>
                                                        </div>
                                                    </fieldset>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>


                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                            <fieldset class="checkbox">
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="special" {{ $product->special ? 'checked' : '' }}>
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span>محصول ویژه؟</span>
                                                </div>
                                            </fieldset>
                                        </div>
                                        @if(option('stock-amount-increased_sms') == 'on')
                                            <div class="col-md-5">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <!-- فیلد مخفی برای ارسال مقدار false به صورت پیش‌فرض -->
                                                        <input type="hidden" name="stock_increase_sms" value="false">
                                                        <!-- چک‌باکس برای ارسال مقدار true -->
                                                        <input type="checkbox" name="stock_increase_sms" value="true">
                                                        <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                        </span>
                                                        <span>ارسال پیامک موجود شدن کالا به کاربران لیست به من اطلاع دهید</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        @endif

                                    </div>
                                    <div id="special-end-date-container" class="row" style="display: hidden;">
                                        <div class="col-md-3 col-12">
                                            <div class="form-group">
                                                <label>تاریخ انقضای ویژه بودن محصول</label>
                                                <input type="text" name="special_end_date" class="form-control persian-date-picker" data-timestamps="true" value="{{ $product->special_end_date ? jdate($product->special_end_date)->getTimestamp() : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">ویرایش محصول</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                </form>
                <div id="form-progress" class="progress progress-bar-success progress-xl" style="display: none;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:0%">0%</div>
                </div>
            </div>

        </div>
    </div>

    @include('back.products.partials.specification-template')
    @include('back.products.partials.prices-template')
    @include('back.products.partials.files-template')

@endsection

@include('back.partials.plugins', ['plugins' => ['ckeditor', 'jquery-tagsinput', 'jquery.validate', 'jquery-ui', 'jquery-ui-sortable', 'dropzone', 'persian-datepicker']])

@php
    $help_videos = [config('general.video-helpes.products-create')];
@endphp

@push('scripts')
    <script>
        /* load saved image gallery */
        var mockImages = [];
        @foreach ($product->gallery()->orderBy('ordering')->get() as $image)
            mockImages.push({
                name: '{{ $image->image }}',
                galleryImage: true,
                type: 'image/jpeg',
                status: 'success',
                upload: {
                    filename: '{{ $image->image }}',
                },
                prevFile: true,
                accepted: true,
                image: '{{ $image->image }}',
                color_id: '{{ $image->color_id }}',
            });
        @endforeach

        var product = {{ $product->id }};

        var groupCount = {{ $product->specificationGroups->unique()->count() }};
        var specificationCount = {{ $product->specifications->unique()->count() }};

        var availableTypes = [
            @foreach ($specTypes as $spec_type)
                '{{ $spec_type->name }}',
            @endforeach
        ];

        var specifications_type_first_change = true;

        var priceCount = {{ $product->prices()->count() }};
        var filesCount = {{ $product->files()->count() }};
        var sizesCount = {{ $product->sizes()->count() }};
    </script>

    <script src="{{ asset('back/assets/js/pages/products/all.js') }}?v=13"></script>
    <script src="{{ asset('back/assets/js/pages/products/edit.js') }}?v=8"></script>
@endpush
