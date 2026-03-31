@php
    $input_value = option($setting['key']);
@endphp

<div class="{{ $setting['class'] ?? 'col-md-6 col-12' }}">
    <fieldset class="form-group">
        <label>{{ $setting['title'] }}</label>
        <div class="custom-file">
            <input id="image" type="file" name="settings[{{ $setting['key'] }}]" class="custom-file-input" {!! $setting['attributes'] ?? '' !!}>
            <label class="custom-file-label" for="image">{{ $input_value }}</label>
        </div>
    </fieldset>
</div>
