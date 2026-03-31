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
                                    <li class="breadcrumb-item">مدیریت کاربران
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.users.show', ['user' => $wallet->user]) }}">{{ $wallet->user->fullname }}</a></li>
                                    <li class="breadcrumb-item active">ایجاد تراکنش کیف پول
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <!-- Description -->
                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">ایجاد تراکنش کیف پول (موجودی: {{ number_format($wallet->balance) }} تومان)</h4>
                        <div>
                            <a href="{{ route('admin.wallets.show', ['wallet' => $wallet]) }}" class="btn btn-warning waves-effect waves-light">بازگشت به کیف پول </a>
                        </div>
                    </div>

                    <div id="main-card" class="card-content">
                        <div class="card-body">
                            <div class="col-12 col-md-10 offset-md-1">
                                <form class="form" id="history-create-form" action="{{ route('admin.wallets.store', ['wallet' => $wallet]) }}" data-redirect="{{ route('admin.wallets.show', ['wallet' => $wallet]) }}">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>مبلغ </label>
                                                    <input type="number" class="form-control amount-input" name="amount">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label>نوع عملیات</label>
                                                    <select class="form-control" name="type">
                                                        <option value="deposit">افزایش اعتبار</option>
                                                        <option value="withdraw">کاهش اعتبار</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>توضیحات </label>
                                                    <textarea name="description" rows="3" class="form-control"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12 text-right">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">ایجاد تراکنش </button>
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

@include('back.partials.plugins', ['plugins' => ['jquery.validate']])

@push('scripts')
    <script src="{{ asset('back/assets/js/pages/wallets/create.js') }}"></script>
@endpush
