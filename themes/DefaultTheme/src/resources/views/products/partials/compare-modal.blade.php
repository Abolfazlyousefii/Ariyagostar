<!-- Modal -->
<div class="modal fade compare-modal" id="compareModal" tabindex="-1" role="dialog" aria-labelledby="compareModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="compareModalLabel">{{ trans('front::messages.products.add-product-for-comparison') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="compare-products-form" action="{{ route('front.products.similar-compare') }}">
                    @csrf
                    @foreach ($products as $product)
                        <input type="hidden" name="products[]" value="{{ $product->id }}">    
                    @endforeach
                    <input type="hidden" name="current_url" value="{{ $current_url }}">

                    <div class="row">
                        <div class="col-9">
                            <input type="text" class="form-control" name="search" placeholder="{{ trans('front::messages.products.search-1') }}" required>
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-primary">{{ trans('front::messages.products.search') }}</button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="row products-row">
                    @if ($similar_products->count())
                        @foreach ($similar_products as $product)
                            <div class="col-md-3 mb-3">
                                <div class="compare-product">
                                <a href="{{ $current_url . '/' . $product->id }}">
                                        <img class="w-100" data-src="{{ $product->image }}" alt="{{ $product->title }}">
                                        <p class="product-title">{{ $product->title }}</p>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <p>{{ trans('front::messages.products.nothing-to-compare') }}</p>
                        </div>
                    @endif
                    
                </div>
            </div>

        </div>
    </div>
</div>
