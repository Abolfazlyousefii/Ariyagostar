@extends('back.layouts.master')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="content-body">
                <form id="filter-products-form" method="GET" class="d-print-none" action="">
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


                                        <div class="col-md-2">
                                            <label>برند</label>
                                            <fieldset class="form-group">
                                                <select class="form-control select2" name="brand_id">
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>دسته بندی ها</label>
                                                <select class="form-control product-category" name="category_id[]" multiple>

                                                    @foreach ($categories as $category)
                                                        <option class="l{{ $category->parents()->count() + 1 }} {{ $category->categories()->count() ? 'non-leaf' : '' }}" data-pup="{{ $category->category_id }}" {{ request()->input('category_id') && in_array($category->id, request()->input('category_id')) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label>عنوان</label>
                                            <fieldset class="form-group">
                                                <input class="form-control" name="title" value="{{ request('title') }}">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-2">
                                            <label>آیدی محصول</label>
                                            <fieldset class="form-group">
                                                <input name="id" type="text" class="form-control" value="{{ request()->id }}">
                                            </fieldset>
                                        </div>


                                        <div class="col-md-2">
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
                                        <div class="col-md-2">
                                            <label>وضعیت تخفیف</label>
                                            <fieldset class="form-group">
                                                <select class="form-control" name="discount">
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
                                        <div class="col-md-2">
                                            <label>محصول ویژه</label>
                                            <fieldset class="form-group">
                                                <select class="form-control" name="special">
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
                                            <label>تعداد در صفحه</label>
                                            <fieldset class="form-group">
                                                <input class="form-control" name="per_page" value="{{ request('per_page', 20) }}">
                                            </fieldset>
                                        </div>
                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-success">فیلتر کردن</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">موجودی محصولات</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">



                            @if ($products->count())
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>کد محصول</th>
                                                <th>عنوان</th>
                                                <th>مشخصات قیمت</th>
                                                <th>موجودی</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($products as $product)
                                                @foreach ($product->prices as $price)

                                                    @php
                                                        if (request()->stock == 'available' && $price->stock <= 0) continue;
                                                    @endphp

                                                    <tr>
                                                        <td>{{ $product->id }}</td>
                                                        <td class="d-flex" rowspan="{{ $product->prices->count() }}">
                                                            {{ $product->title }} <a class="d-print-none" href="{{ route('front.products.show', ['product' => $product]) }}" target="_blank"><i class="feather icon-external-link pl-1"></i></a>
                                                        </td>

                                                        <td>
                                                            {{ $price->getAttributesValue() }}
                                                        </td>

                                                        <td>{{ number_format($price->stock) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p>چیزی برای نمایش وجود ندارد!</p>
                            @endif

                        </div>
                    </div>
                </section>

                {{ $products->links() }}

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.product-category').select2ToTree({
            rtl: true,
            width: '100%',
            placeholder: 'انتخاب کنید'
        });
    </script>
@endpush
