
<div class="{{ $option['class'] ?? 'col-md-6 col-12' }}">
    <div class="form-group">
        <label>{{ $option['title'] }}</label>
        <select id="post-categories-{{ $option['key'] }}" class="form-control" name="options[{{ $option['key'] }}][]" {!! $option['attributes'] ?? '' !!} multiple>
            @foreach ($post_categories as $category)
                @php

                    $selected = false;

                    if (isset($widget)) {
                        $widget_option = $widget->options()->where('key', $option['key'])->first();
                        if ($widget_option && $widget_option->categories()->find($category->id)) {
                            $selected = true;
                        }
                    }
                @endphp

                <option
                    class="l{{ $category->parents()->count() + 1 }} {{ $category->categories()->count() ? 'non-leaf' : '' }}"
                    data-pup="{{ $category->category_id }}"
                    {{ $selected ? 'selected' : '' }}
                    value="{{ $category->id }}">{{ $category->title }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<script>
    setTimeout(() => {
        $("#post-categories-{{ $option['key'] }}").select2ToTree({
            rtl: true,
            width: '100%',
        });
    }, 300);
</script>
