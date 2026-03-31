@if($sliders->count())
    <section class="card sliders-sortable">
        <div class="card-header">
            <h4 class="card-title">{{ $title }}</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">ردیف</th>
                                <th>تصویر</th>
                                <th>عنوان</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                        </thead>
                        <tbody id="sliders-sortable-{{ $loop->index }}">
                            @foreach($sliders as $slider)
                                <tr id="slider-{{ $slider->id }}">
                                    <td class="text-center draggable-handler">
                                        <div class="fonticon-wrap"><i class="feather icon-move"></i></div>
                                    </td>
                                    <td>
                                        <div class="slider-thumb">
                                            <img src="{{ asset($slider->image) }}" alt="avtar img holder">
                                        </div>
                                    </td>
                                    <td>{{ $slider->title ?: '--' }}</td>
                                    <td class="text-center">
                                        @if($slider->published)
                                            <div class="badge badge-pill badge-success badge-md">منتشر شده</div>
                                        @else
                                            <div class="badge badge-pill badge-danger badge-md">پیش نویس</div>
                                        @endif
                                    </td>
                                    <td class="text-center">

                                        @can('sliders.update')
                                            <a href="{{ route('admin.sliders.edit', ['slider' => $slider]) }}" class="btn btn-info mr-1 waves-effect waves-light">ویرایش</a>
                                        @endcan

                                        @can('sliders.delete')
                                            <button type="button" data-slider="{{ $slider->id }}" class="btn btn-danger mr-1 waves-effect waves-light btn-delete"  data-toggle="modal" data-target="#delete-modal">حذف</button>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@else
    <section class="card">
        <div class="card-header">
            <h4 class="card-title">{{ $title }}</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="card-text">
                    <p>چیزی برای نمایش وجود ندارد!</p>
                </div>
            </div>
        </div>
    </section>
@endif
