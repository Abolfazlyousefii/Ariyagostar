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
            <div class="users-list-filter">
                <form id="filter-users-form"" method="GET"
                      action="{{ route('admin.users.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label>نام</label>
                            <fieldset class="form-group">
                                <input class="form-control datatable-filter" name="fullname" value="{{ request('fullname') }}">
                            </fieldset>
                        </div>

                        <div class="col-md-3">
                            <label>نام کاربری</label>
                            <fieldset class="form-group">
                                <input class="form-control datatable-filter" name="username" value="{{ request('username') }}">
                            </fieldset>
                        </div>
                        <div class="col-md-3">
                            <label>ایمیل</label>
                            <fieldset class="form-group">
                                <input class="form-control datatable-filter" name="email" value="{{ request('email') }}">
                            </fieldset>
                        </div>

                        <div class="col-md-3">
                            <label>نقش</label>
                            <fieldset class="form-group">
                                <select class="form-control datatable-filter" name="level">
                                    <option value="all" {{ request('level') == 'all' ? 'selected' : '' }}>
                                        همه
                                    </option>
                                    <option value="admin" {{ request('level') == 'admin' ? 'selected' : '' }}>
                                        مدیر
                                    </option>
                                    <option value="user" {{ request('level') == 'user' ? 'selected' : '' }}>
                                        کاربر عادی
                                    </option>
                                </select>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
