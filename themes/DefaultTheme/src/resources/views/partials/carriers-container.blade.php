@php
    $carrier_found = false;
@endphp

<div id="checkout-carrier-container">

    <div class="dt-sn pt-3 pb-3">
        <div class="row">
            <div class="checkout-time-table checkout-time-table-time">
                @foreach ($carriers as $carrier)

                    @if (\App\Models\Cart::canUseCarrier($carrier->id, $cart->weight(), $cart->city_id)['status'])
                        <div class="col-12">
                            <div class="radio-box custom-control custom-radio form-group mb-0 pl-0 pr-3">
                                <input type="radio" class="custom-control-input form-control" name="carrier_id" id="carrier-{{ $carrier->id }}" value="{{ $carrier->id}}" {{ $cart->carrier_id == $carrier->id ? 'checked' : '' }}>
                                <label for="carrier-{{ $carrier->id }}" class="custom-control-label">
                                    @if ($carrier->image)
                                        <img src="{{ asset($carrier->image) }}" class="checkout-additional-options-checkbox-image" />
                                    @endif

                                    <div class="content-box">
                                        <div class="checkout-time-table-title-bar checkout-time-table-title-bar-city">{{ $carrier->title }}</div>
                                        <ul class="checkout-time-table-subtitle-bar">
                                            <li>{{ $carrier->description }}</li>
                                        </ul>
                                    </div>
                                </label>
                            </div>
                        </div>

                        @php
                            $carrier_found = true;
                        @endphp

                    @endif

                @endforeach

                @if (!$carrier_found)
                    <div class="col-12">
                        <div class="alert alert-danger">
                            {{ trans('front::messages.partials.how-to-send') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
