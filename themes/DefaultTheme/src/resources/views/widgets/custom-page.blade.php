@php
    $variables = get_widget($widget);
    $page      = $variables['page'];
    $color     = $variables['block_color'];
@endphp
<section class="text-box text-center p-4 dt-sl my-3" style="background-color: {{ $color }}">
    <div class="row">
        <div class="col-12">
            {!! $page->content !!}
        </div>
    </div>
</section>
