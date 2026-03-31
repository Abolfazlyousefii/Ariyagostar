@php
    $input_value = option($setting['key'], $setting['default'] ?? false);
@endphp

<div class="{{ $setting['class'] ?? 'col-md-6 col-12' }}">
    <div class="form-group">
        <label>{{ $setting['title'] }}</label>
        <input type="{{ $setting['type'] ?? 'text' }}" class="form-control" name="settings[{{ $setting['key'] }}]" value="{{ $input_value }}" {!! $setting['attributes'] ?? '' !!}>
    </div>
</div>
