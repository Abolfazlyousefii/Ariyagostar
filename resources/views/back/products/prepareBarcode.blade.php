@extends('back.layouts.master')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">

            <div class="content-body">

                <form action="{{ route('admin.product.printBarcode') }}" method="POST">
                    @csrf

                    @foreach ($request->input('filters') as $key => $value)
                        <input type="hidden" name="filters[{{ $key }}]" value="{{ $value }}">
                    @endforeach

                    <section class="card" id="main-card">
                        <div class="card-header">
                            <h4 class="card-title">چاپ بارکد قیمت ها</h4>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li>
                                        <button type="submit" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-save"></i> چاپ بارکد</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @foreach ($products as $product)
                                    <div class="price-item">
                                        <div class="row align-items-center">
                                            <div class="col-md-1 text-center">
                                                <img class="post-thumb" src="{{ $product->imageUrl() }}" alt="image">
                                            </div>
                                            <div class="col-md-11">
                                                <div class="row">
                                                    <div class="col-12 pt-2 pb-1">
                                                        {{ $product->title }}
                                                        <a tabindex="-1" class="float-right" href="{{ Route::has('front.products.show') ? route('front.products.show', ['product' => $product]) : '' }}" target="_blank">
                                                            <i class="feather icon-external-link"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="prices-input-area">
                                                    <div class="row d-none d-md-flex">
                                                        <div class="col-5"></div>

                                                        <div class="col-2">
                                                            <span>تعداد چاپ:</span>
                                                        </div>
                                                    </div>
                                                    <hr class="price-seperator">
                                                    @foreach ($product->prices as $price)
                                                        <div class="row" style="margin-top: 3px;margin-bottom: 3px">
                                                            <div class="col-md-5">
                                                                <span>{{ $price->getAttributesName() }}</span>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input  name="prices[{{ $price->id }}][id]" value="{{ $price->id }}" type="hidden">
                                                                <input class="form-control form-control-sm ltr text-center" name="prices[{{ $price->id }}][count]" value="{{ $price->stock }}" type="number">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="heading-elements">
                                <ul class="list-inline d-block mb-0">
                                    <li>
                                        <button type="submit" class="btn btn-outline-primary waves-effect waves-light">
                                            <i class="fa fa-save"></i> چاپ بارکد
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </section>
                </form>

            </div>
        </div>
    </div>
@endsection
