<div class="{{ $option['class'] ?? 'col-md-6 col-12' }}">
    <div class="form-group">
        <label>{{ $option['title'] }}</label>
        <select class="form-control" name="options[page_id]" required>
            @foreach ($pages as $page)
                <option value="{{ $page->id }}" {{ isset($widget) && $widget->option("page_id") == $page->id ? "selected" : '' }}>{{ $page->title }}</option>
            @endforeach
        </select>
    </div>
</div>
