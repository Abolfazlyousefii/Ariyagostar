<div id="checkout-sidebar" class="col-xl-3 col-lg-4 col-12 w-res-sidebar sticky-sidebar">
    @if ($order->carrier_id)
        <div class="dt-sn mb-2 details">
            <ul class="checkout-summary-summary">
                <li>
                    <span>{{ trans('front::messages.partials.shipping-cost') }}</span>
                    <span id="final-price" data-value="{{ $order->shippingCostAmount() }}">
                        {{ $order->shippingCost() }}
                    </span>
                </li>
            </ul>
            <div class="checkout-summary-devider">
                <div></div>
            </div>
            <div class="checkout-summary-content">
                <button id="checkout-link" type="button" class="btn-primary-cm btn-with-icon w-100 text-center pr-0 checkout_link">
                    <i class="mdi mdi-arrow-left"></i>
                    پرداخت هزینه ارسال
                </button>

            </div>
        </div>
    @endif
</div>
