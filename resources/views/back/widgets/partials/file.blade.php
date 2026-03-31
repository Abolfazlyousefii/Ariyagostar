@php
    $input_value = isset($widget) && $widget ? $widget->option($option['key']) : '';
@endphp

<div class="{{ $option['class'] ?? 'col-md-6 col-12' }}">
    <fieldset class="form-group">
        <label>{{ $option['title'] }}</label>
        <div class="custom-file">
            <input id="image" type="file" name="options[{{ $option['key'] }}]" class="custom-file-input" {!! $option['attributes'] ?? '' !!}>
            <label class="custom-file-label" for="image">{{ $input_value }}</label>
        </div>
        @isset($option['help'])
            <p class="text-muted m-0">{{ $option['help'] }}</p>
        @endisset
    </fieldset>
</div>
