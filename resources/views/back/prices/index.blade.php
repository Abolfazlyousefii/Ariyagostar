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
                                    <li class="breadcrumb-item">مدیریت</li>
                                    <li class="breadcrumb-item">محصولات</li>
                                    <li class="breadcrumb-item active">تغییر قیمت محصولات</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Description -->
                <section id="description" class="card">
                    <div class="card-header">
                        <h4 class="card-title">تغییر قیمت گروهی</h4>
                    </div>

                    <div id="main-card" class="card-content">
                        <div class="card-body">
                            <div class="col-12 col-md-10 offset-md-1">
                                <form class="form" action="{{ route('admin.prices.show') }}" method="GET">

                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>برند</label>
                                                    <select class="form-control select2" name="brand_id" required>
                                                        <option value="">انتخاب کنید</option>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>دسته بندی ها</label>
                                                    <select class="form-control product-category" name="category_id[]" multiple>
                                                        <option class="l1 " data-pup="" {{ request()->input('category_id') && in_array('no_category', request()->input('category_id')) ? 'selected' : '' }} value="no_category">بدون دسته بندی</option>
                                                        @foreach ($categories as $category)
                                                            <option class="l{{ $category->parents()->count() + 1 }} {{ $category->categories()->count() ? 'non-leaf' : '' }}" data-pup="{{ $category->category_id }}" {{ request()->input('category_id') && in_array($category->id, request()->input('category_id')) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>نوع عملیات</label>
                                                    <select name="type" class="form-control" required>
                                                        <option value="">انتخاب کنید</option>
                                                        <option value="increase">افزایش قیمت</option>
                                                        <option value="decrease">کاهش قمیت</option>
                                                        <option value="discount">تخفیف واقعی</option>
                                                        <option value="fake_discount"> تخفیف غیر واقعی</option>
                                                        <option value="remove_fake_discount">حذف تخفیف غیر واقعی</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 price-fields" style="display: none;">
                                                <div class="form-group">
                                                    <label>نوع افزایش / کاهش</label>
                                                    <select name="amount_type" class="form-control">
                                                        <option value="">انتخاب کنید</option>
                                                        <option value="percentage">درصدی</option>
                                                        <option value="price">مبلغ</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 price-fields" style="display: none;">
                                                <div class="form-group">
                                                    <label>مقدار <small>(درصد یا مبلغ)</small></label>
                                                    <input type="number" class="form-control ltr" name="amount">
                                                </div>
                                            </div>
                                            <div class="col-md-3 discount-fields" style="display: none;">
                                                <div class="form-group">
                                                    <label>درصد تخفیف</label>
                                                    <input type="number" class="form-control ltr" name="discount">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1 waves-effect waves-light">ادامه</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Description -->

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('select[name="type"]').on('change', function () {
            $('.price-fields').hide();
            $('.discount-fields').hide();

            switch ($(this).find(":selected").val()) {
                case "increase":
                case "decrease": {
                    $('.price-fields').show();
                    break;
                }
                case "discount":
                case "fake_discount": {
                    $('.discount-fields').show();
                    break;
                }
            }
        });

        $('.product-category').select2ToTree({
            rtl: true,
            width: '100%',
            placeholder: 'انتخاب کنید'
        });
    </script>
@endpush
