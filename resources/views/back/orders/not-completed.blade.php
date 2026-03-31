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
                                    <li class="breadcrumb-item">مدیریت سفارشات
                                    </li>
                                    <li class="breadcrumb-item active">محصولات منتظر ارسال
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">

                @if($prices->count())
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست محصولات </h4>
                        </div>
                        <div class="card-content" id="main-card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center"></th>
                                                <th class="text-center"></th>
                                                <th>عنوان</th>
                                                <th class="text-center">تعداد</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($prices as $price)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>
                                                        <img class="post-thumb" src="{{ $price->product->imageUrl() }}" alt="image">
                                                    </td>
                                                    <td>
                                                        <p>{{ $price->product->title }}</p>
                                                        {{ $price->getAttributesName() }}
                                                    </td>
                                                    <td class="text-center">{{ $price->pendingToSend() }}</td>
                                                    <td class="text-center">
                                                        <a class="float-right" href="{{ $price->product->link() }}" target="_blank">
                                                            <i class="feather icon-external-link"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>

                @else
                    <section class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست محصولات منتظر ارسال</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="card-text">
                                    <p>چیزی برای نمایش وجود ندارد!</p>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

                {{ $prices->links() }}


            </div>
        </div>
    </div>

@endsection
