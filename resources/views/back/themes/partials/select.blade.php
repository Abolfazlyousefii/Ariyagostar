<div class="{{ $setting['class'] ?? 'col-md-6 col-12' }}">
    <div class="form-group">
        <label>{{ $setting['title'] }}</label>
        <select class="form-control" name="settings[{{ $setting['key'] }}]" {!! $setting['attributes'] ?? '' !!}>
            @foreach ($setting['options'] as $item)

                @php
                    $selected = option($setting['key']) == $item['value'];
                @endphp

                <option value="{{ $item['value'] }}" {{ $selected ? 'selected' : '' }}>{{ $item['title'] }}</option>
            @endforeach
        </select>
    </div>
</div>
