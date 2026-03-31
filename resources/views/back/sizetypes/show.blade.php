@if ($sizetype->values->count())
    @foreach ($sizetype->values->groupBy('pivot.group') as $sizes)
        <div class="row mt-2 align-items-center single-value">
            <div class="col-md-1">
                <button type="button" class="btn btn-flat-danger waves-effect waves-light remove-value custom-padding"><i class="feather icon-minus"></i></button>
            </div>

            <div class="col-md-10">
                <div class="row">
                    @foreach ($sizetype->sizes as $size)
                        @php
                            $group = $sizes->first()->pivot->group;
                            $value = $sizetype->values()->where('size_id', $size->id)->where('group', $group)->first()->pivot->value ?? '';
                        @endphp

                        <div class="col-md-3">
                            <label for="">{{ $size->title }}</label>
                            <input data-size-id="{{ $size->id }}" type="text" class="form-control" name="sizes[{{ $loop->parent->index }}][{{ $size->id }}]" value="{{ $value }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-12">
                <hr class="m-0 mt-1">
            </div>
        </div>
    @endforeach
@else
    <div class="row mt-2 align-items-center single-value">
        <div class="col-md-1">
            <button type="button" class="btn btn-flat-danger waves-effect waves-light remove-value custom-padding"><i class="feather icon-minus"></i></button>
        </div>

        <div class="col-md-10">
            <div class="row">
                @foreach ($sizetype->sizes as $size)
                    <div class="col-md-3">
                        <label for="">{{ $size->title }}</label>
                        <input data-size-id="{{ $size->id }}" type="text" class="form-control" name="sizes[0][{{ $size->id }}]">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-12">
            <hr class="m-0 mt-1">
        </div>
    </div>
@endif

<script>
    sizesCount = {{ $sizetype->sizes->count() ?: 1 }};
</script>
