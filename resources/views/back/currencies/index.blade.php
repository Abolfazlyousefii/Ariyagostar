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
                                    <li class="breadcrumb-item">پرداخت
                                    </li>
                                    <li class="breadcrumb-item active">لیست ارزها
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                <section id="main-card" class="card">
                    <div class="card-header">
                        <h4 class="card-title">لیست ارزها</h4>
                        <div>
                            <a href="{{ route('admin.currencies.create') }}" class="btn btn-info waves-effect waves-light"><i class="feather icon-plus"></i> ایجاد ارز جدید</a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body table-responsive">

                            @if($currencies->count())
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>ردیف</th>
                                            <th>عنوان</th>
                                            <th>نرخ (تومان)</th>
                                            <th class="text-center">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($currencies as $currency)

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $currency->title }}</td>
                                                <td>{{ number_format($currency->amount()) }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.currencies.edit', ['currency' => $currency]) }}" class="btn btn-warning waves-effect waves-light">ویرایش</a>
                                                    <button type="button" data-action="{{ route('admin.currencies.destroy', ['currency' => $currency]) }}" class="btn btn-danger waves-effect waves-light btn-delete"  data-toggle="modal" data-target="#delete-modal">حذف</button>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @else
                                <div class="card-text">
                                    <p>چیزی برای نمایش وجود ندارد!</p>
                                </div>
                            @endif

                            {{ $currencies->links() }}
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    {{-- delete currency modal --}}
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
                    با حذف ارز  دیگر قادر به بازیابی آن نخواهید بود
                </div>
                <div class="modal-footer">
                    <form action="#" id="currency-delete-form">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-success waves-effect waves-light" data-dismiss="modal">خیر</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">بله حذف شود</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/currencies/index.js') }}"></script>
@endpush
