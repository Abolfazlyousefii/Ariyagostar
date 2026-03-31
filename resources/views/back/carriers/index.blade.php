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
                                    <li class="breadcrumb-item">مدیریت روش های ارسال
                                    </li>
                                    <li class="breadcrumb-item active">لیست روش های ارسال
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">لیست روش های ارسال</h4>
                        <div>
                            <a href="{{ route('admin.carriers.create') }}" class="btn btn-info waves-effect waves-light"><i class="feather icon-plus"></i> ایجاد روش ارسال</a>
                        </div>
                    </div>
                    <div class="card-content" id="main-card">
                        <div class="card-body">
                            @if ($carriers->count())
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>ردیف</th>
                                                <th>عنوان</th>
                                                <th>شهر فروشگاه</th>
                                                <th>شهرهای تحت پوشش</th>
                                                <th>پس کرایه</th>
                                                <th class="text-center">وضعیت</th>
                                                <th class="text-center">عملیات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($carriers as $carrier)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $carrier->title }}</td>
                                                    <td>{{ $carrier->province->name }} - {{ $carrier->city->name }}</td>
                                                    <td>
                                                        @if ($carrier->covered_cities == 'all')
                                                            <span>همه</span>
                                                        @else
                                                            <abbr title="مشاهده لیست شهرها"><a class="carrier-cities-show" href="{{ route('admin.carriers.cities', ['carrier' => $carrier]) }}">لیست شهرها</a></abbr>
                                                        @endif
                                                    </td>
                                                    <td>{{ $carrier->carrige_forward ? 'بله' : 'خیر' }}</td>
                                                    <td class="text-center">
                                                        @if($carrier->is_active)
                                                            <div class="badge badge-pill badge-success badge-md">فعال</div>
                                                        @else
                                                            <div class="badge badge-pill badge-danger badge-md">غیر فعال</div>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">

                                                        @if ($carrier->carrige_forward)
                                                            <button class="btn btn-secondary waves-effect waves-light" disabled>تعرفه ها</button>
                                                        @else
                                                            <a href="{{ route('admin.tariffs.index', ['carrier' => $carrier]) }}" class="btn btn-info waves-effect waves-light">تعرفه ها</a>
                                                        @endif

                                                        <a href="{{ route('admin.carriers.edit', ['carrier' => $carrier]) }}" class="btn btn-warning waves-effect waves-light">ویرایش</a>
                                                        <button type="button" data-action="{{ route('admin.carriers.destroy', ['carrier' => $carrier]) }}" class="btn btn-danger waves-effect waves-light btn-delete"  data-toggle="modal" data-target="#delete-modal">حذف</button>
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

                {{ $carriers->links() }}

            </div>
        </div>
    </div>

    {{-- delete carrier modal --}}
    <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel19" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel19">آیا مطمئن هستید؟</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    با حذف روش ارسال دیگر قادر به بازیابی آن نخواهید بود
                </div>
                <div class="modal-footer">
                    <form action="#" id="carrier-delete-form">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">خیر</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">بله حذف شود</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- show Modal -->
    <div class="modal fade text-left" id="show-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel21">لیست شهرهای تحت پوشش</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="carrier-cities-list" class="modal-body">


                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/carriers/index.js') }}"></script>
@endpush
