<div class="card">
    <div class="card-header filter-card">
        <h4 class="card-title">فیلتر کردن</h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse {{ request()->except('page') ? 'show' : '' }}">
        <div class="card-body">
            <div class="provinces-list-filter">
                <form id="filter-provinces-form" method="GET" action="{{ route('admin.provinces.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label>نام</label>
                            <fieldset class="form-group">
                                <input class="form-control datatable-filter" name="name" value="{{ request('name') }}">
                            </fieldset>
                        </div>
                        <div class="col-md-3">
                            <label>نام شهر</label>
                            <fieldset class="form-group">
                                <input class="form-control datatable-filter" name="city_name" value="{{ request('city_name') }}">
                            </fieldset>
                        </div>
                        <div class="col-md-3">
                            <label>وضعیت</label>
                            <fieldset class="form-group">
                                <select class="form-control datatable-filter" name="is_active" value="{{ request('is_active') }}">
                                    <option value="">همه</option>
                                    <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>فعال</option>
                                    <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>غیر فعال</option>
                                </select>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
