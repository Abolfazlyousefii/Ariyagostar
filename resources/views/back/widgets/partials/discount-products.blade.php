<div class="{{ $option['class'] ?? 'col-md-6 col-12' }}">
    <div class="form-group">
        <label>{{ $option['title'] }}</label>
        <select class="form-control" name="options[{{ $option['key'] }}]">
            @foreach ($discount_products as $discount)
                @php
                    $selected = isset($widget) && $widget->option($option['key']) == $discount->id;
                @endphp

                <option value="{{ $discount->id }}" {{ $selected ? 'selected' : '' }}>{{ $discount->title }}</option>
            @endforeach
        </select>
    </div>
</div>
