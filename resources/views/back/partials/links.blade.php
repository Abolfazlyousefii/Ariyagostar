@if($links->where('link_group_id', $group['key'])->count())
    <section class="card links-sortable">
        <div class="card-header">
            <h4 class="card-title">{{ option('link_groups_' . $group['key'], $group['name']) }}</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">ردیف</th>
                                <th>عنوان</th>
                                <th>لینک</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                        </thead>
                        <tbody id="links-sortable-{{ $loop->index }}">
                            @foreach($links->where('link_group_id', $group['key']) as $link)
                                <tr id="link-{{ $link->id }}">
                                    <td class="text-center draggable-handler">
                                        <div class="fonticon-wrap"><i class="feather icon-move"></i></div>
                                    </td>

                                    <td>{{ $link->title }}</td>
                                    <td>{{ $link->link }}</td>

                                    <td class="text-center">

                                        @can('links.update')
                                            <a href="{{ route('admin.links.edit', ['link' => $link]) }}" class="btn btn-info mr-1 waves-effect waves-light">ویرایش</a>
                                        @endcan

                                        @can('links.delete')
                                            <button type="button" data-link="{{ $link->id }}" class="btn btn-danger mr-1 waves-effect waves-light btn-delete"  data-toggle="modal" data-target="#delete-modal">حذف</button>
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
    <section class="card links-sortable">
        <div class="card-header">
            <h4 class="card-title">{{ $group['name'] }}</h4>
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
