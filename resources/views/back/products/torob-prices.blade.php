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
                                    <li class="breadcrumb-item">مدیریت محصولات</li>
                                    <li class="breadcrumb-item active">مقایسه قیمت ترب</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

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
                                <form id="filter-products-form" method="GET" action="">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>عنوان</label>
                                            <fieldset class="form-group">
                                                <input class="form-control datatable-filter" name="title" value="{{ request('title') }}">
                                            </fieldset>
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
                                            <label>نیاز به بررسی</label>
                                            <fieldset class="form-group">
                                                <select name="review_need" class="form-control">
                                                    <option value="">همه موارد</option>
                                                    <option value="1" {{ request()->review_need == '1' ? 'selected' : '' }}>دارد</option>
                                                    <option value="0" {{ request()->review_need == '0' ? 'selected' : '' }}>ندارد</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-3">
                                            <label>وضعیت ادغام</label>
                                            <fieldset class="form-group">
                                                <select name="is_merged" class="form-control">
                                                    <option value="">همه موارد</option>
                                                    <option value="1" {{ request()->is_merged == '1' ? 'selected' : '' }}>ادغام شده</option>
                                                    <option value="0" {{ request()->is_merged == '0' ? 'selected' : '' }}>ادغام نشده</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-3">
                                            <label>مرتب سازی</label>
                                            <fieldset class="form-group">
                                                <select name="sort" class="form-control">
                                                    <option value="last_update" {{ request()->sort == 'last_update' ? 'selected' : '' }}>بر اساس آخرین آپدیت</option>
                                                    <option value="created_at" {{ request()->sort == 'created_at' ? 'selected' : '' }}>بر اساس تاریخ ایجاد محصول</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-12 text-right">
                                            <button type="submit" class="btn btn-success waves-effect waves-light">فیلتر کردن</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">مقایسه قیمت ترب</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a href="{{ route('admin.product.torobImport') }}" class="btn btn-outline-primary waves-effect waves-light px-1"><i class="fa fa-file-excel-o"></i> وارد کردن لینک ها از اکسل</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content" id="main-card">
                        <div class="card-body">
                            @if ($torobs->count())
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>محصول</th>
                                                <th>قیمت</th>
                                                <th>قیمت در ترب</th>
                                                <th>فروشگاه</th>
                                                <th>آخرین تغییر قیمت</th>
                                                <th>وضعیت ادغام</th>
                                                <th class="text-center">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($torobs as $torob)
                                                @php
                                                    $lowest_price = $torob->product->getLowestPrice(true);
                                                    $percentageDifference = $torob->price ? percentageDifference($lowest_price, $torob->price) : 0;
                                                @endphp

                                                <tr title="{{ number_format($percentageDifference) . ' درصد اختلاف قیمت' }}">
                                                    <td class="{{ $percentageDifference > 20 ? 'bg-danger text-white' : '' }}">{{ $loop->iteration }}</td>
                                                    <td title="آخرین آپدیت {{ $torob->last_update ? jdate($torob->last_update)->ago() : '-' }}">
                                                        <img class="post-thumb" src="{{ $torob->product->imageUrl() }}" alt="image">
                                                        <span class="d-flex mt-1">
                                                            <span>{{ $torob->product->title }}</span>
                                                            @if (Route::has('front.products.show'))
                                                                <a href="{{ route('front.products.show', ['product' => $torob->product]) }}" target="_blank"><i class="feather icon-external-link ml-1"></i></a>
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td class="{{ $torob->review_need ? 'text-danger' : 'text-success' }}">
                                                        {{ number_format($lowest_price) }}
                                                    </td>
                                                    <td title="لینک محصول در ترب" class="text-success">
                                                        <a href="{{ $torob->link ? $torob->link->link : $torob->links()->first()->link }}" target="_blank">
                                                            {{ $torob->price ? number_format($torob->price) : 'لینک ترب' }}
                                                        </a>
                                                    </td>
                                                    <td title="{{ $torob->title }}">
                                                        <a href="{{ $torob->price_link }}" target="_blank">
                                                            {{ $torob->shop_name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $torob->last_price_change }}
                                                    </td>
                                                    <td>
                                                        @if ($torob->is_merged)
                                                            <div class="badge badge-pill badge-success badge-md">ادغام شده</div>
                                                        @else
                                                            <div class="badge badge-pill badge-danger badge-md">ادغام نشده</div>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a title="مشاهده فروشگاه" href="{{ $torob->price_link }}" target="_blank"><i class="feather icon-external-link"></i></a>
                                                        <a title="ویرایش" href="{{ route('admin.products.edit', ['product' => $torob->product]) }}" target="_blank"><i class="feather icon-edit"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="card-text">
                                    <p>چیزی برای نمایش وجود ندارد!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>

                {{ $torobs->links() }}

            </div>
        </div>
    </div>

@endsection
