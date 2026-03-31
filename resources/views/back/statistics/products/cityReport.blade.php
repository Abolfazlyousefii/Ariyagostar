@extends('back.layouts.master')

@section('content')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="content-body">
                <form id="filter-products-form" method="GET" action="">
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
                                            <label>نوع گزارش</label>
                                            <fieldset class="form-group">
                                                <select class="form-control" name="report_mode">
                                                    <option value="province" {{ request('report_mode') == 'province' ? 'selected' : '' }}>
                                                        بر اساس استان
                                                    </option>
                                                    <option value="city" {{ request('report_mode') == 'city' ? 'selected' : '' }}>
                                                        بر اساس شهر
                                                    </option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-2">
                                            <label>گزارش بر اساس</label>
                                            <fieldset class="form-group">
                                                <select class="form-control" name="report_type">
                                                    <option value="price" {{ request('report_type') == 'price' ? 'selected' : '' }}>
                                                        مبلغ فروش
                                                    </option>
                                                    <option value="quantity" {{ request('report_type') == 'quantity' ? 'selected' : '' }}>
                                                        تعداد فروش
                                                    </option>
                                                </select>
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
                        <h4 class="card-title">گزارش فروش شهرها</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">

                            @if ($orders->count())
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>ردیف</th>
                                                <th>استان/شهر</th>
                                                <th>جمع فروش</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($orders as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="d-flex">
                                                        @if ($item->ref_id)
                                                            @if ($item->province_id)
                                                                {{ \App\Models\Province::find($item->province_id)->name }}
                                                            @else
                                                                {{ \App\Models\City::find($item->city_id)->name }}
                                                            @endif
                                                        @else
                                                            انتخاب نشده
                                                        @endif
                                                    </td>
                                                    <td>{{ number_format($item->total_sale) }}</td>
                                                </tr>
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

                {{ $orders->links() }}

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
