
<div class="tab-pane" id="tabSize" role="tabpanel" aria-labelledby="size-tab">
    <div id="sizes-card" class="card">
        <div class="card-header d-flex justify-content-between align-items-end">
            <h4 class="card-title">سایز بندی</h4>
        </div>
        <div class="card-content">
            <div class="card-body ">
                <div class="row">
                    <div class="col-md-7 text-justify">
                        <p>در این قسمت میتوانید برای محصول راهنمای سایز بندی وارد کنید.</p>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>انتخاب راهنمای سایز</label>
                            <select id="size_type_id" name="size_type_id" class="form-control">
                                <option value="">انتخاب کنید</option>
                                @foreach ($sizetypes as $sizetype)
                                    <option data-action="{{ route('admin.sizetypes.show', ['sizetype' => $sizetype]) }}" value="{{ $sizetype->id }}" {{ $product && $product->size_type_id == $sizetype->id ? 'selected' : '' }}>{{ $sizetype->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-body pt-2">
                    <div class="row">
                        <div class="col-12">
                            <div id="sizes-area" class="all-sizes">
                                @if ($product && $product->sizetype)
                                    @foreach ($product->sizes->groupBy('pivot.group') as $sizes)
                                        <div class="row mt-2 align-items-center single-value">
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-flat-danger waves-effect waves-light remove-value custom-padding"><i class="feather icon-minus"></i></button>
                                            </div>

                                            <div class="col-md-10">
                                                <div class="row">
                                                    @foreach ($product->sizetype->sizes as $size)
                                                        @php
                                                            $group = $sizes->first()->pivot->group;
                                                            $value = $product->sizes()->where('size_id', $size->id)->where('group', $group)->first()->pivot->value ?? '';
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
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 text-center mt-2">
                            <button type="button" class="btn btn-flat-success waves-effect waves-light add-value">افزودن مقدار جدید</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
