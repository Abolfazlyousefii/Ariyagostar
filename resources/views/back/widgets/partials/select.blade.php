<div class="{{ $option['class'] ?? 'col-md-6 col-12' }}">
    <div class="form-group">
        <label>{{ $option['title'] }}</label>
        <select class="form-control" name="options[{{ $option['key'] }}]" {!! $option['attributes'] ?? '' !!}>
            @foreach ($option['options'] as $item)

                @php
                    $selected = isset($widget) && $widget->option($option['key']) == $item['value'];
                @endphp

                <option value="{{ $item['value'] }}" {{ $selected ? 'selected' : '' }}>{{ $item['title'] }}</option>
            @endforeach
        </select>
    </div>
</div>
