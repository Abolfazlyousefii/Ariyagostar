'use strict';
// Class definition

var datatable;

var user_datatable = (function () {
    // Private functions

    var options = {
        // datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    url: $('#users_datatable').data('action'),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content'
                        )
                    },
                    map: function (raw) {
                        // sample data mapping
                        var dataSet = raw;
                        if (typeof raw.data !== 'undefined') {
                            dataSet = raw.data;
                        }
                        return dataSet;
                    },
                    params: {
                        query: $('#filter-users-form').serializeJSON()
                    }
                }
            },
            pageSize: 10,
            serverPaging: true,
            serverFiltering: true,
            serverSorting: true
        },

        layout: {
            scroll: true
        },

        rows: {
            autoHide: false
        },

        // columns definition
        columns: [
            {
                field: 'id',
                title: '#',
                sortable: false,
                width: 20,
                selector: {
                    class: ''
                },
                textAlign: 'center'
            },
            {
                field: 'image',
                title: 'تصویر',
                sortable: false,
                width: 80,
                template: function (row) {
                    return (
                        '<img class="post-thumb" src="' +
                        row.image +
                        '" alt="' +
                        row.title +
                        '">'
                    );
                }
            },
            {
                field: 'fullname',
                title: 'نام',
                width: 200,
                template: function (row) {
                    return row.fullname;
                }
            },
            {
                field: 'username',
                title: 'نام کاربری',
                width: 200,
                template: function (row) {
                    return row.username;
                }
            },
            {
                field: 'created_at',
                sortable: 'desc',
                title: 'تاریخ عضویت',
                template: function (row) {
                    return '<span class="ltr">' + row.created_at + '</span>';
                }
            },
            {
                field: 'actions',
                title: 'عملیات',
                textAlign: 'center',
                sortable: false,
                width: 200,
                overflow: 'visible',
                autoHide: false,
                template: function (row) {
                    return (
                        '<a href ="' +
                        row.links.edit +
                        '"class="btn btn-warning waves-effect waves-light">ویرایش</a>\
                    <a href="' +
                        row.links.show +
                        '" class="btn btn-info waves-effect waves-light">مشاهده</a>'
                    );
                }
            }
        ]
    };

    var initDatatable = function () {
        // enable extension
        options.extensions = {
            // boolean or object (extension options)
            checkbox: true
        };

        datatable = $('#users_datatable').KTDatatable(options);

        $('#filter-users-form .datatable-filter').on('change', function () {
            formDataToUrl('filter-users-form');
            datatable.setDataSourceQuery(
                $('#filter-users-form').serializeJSON()
            );
            datatable.reload();
        });

        datatable.on('datatable-on-click-checkbox', function (e) {
            var ids = datatable.checkbox().getSelectedId();
            var count = ids.length;

            $('#datatable-selected-rows').html(count);

            if (count > 0) {
                $('.datatable-actions').collapse('show');
            } else {
                $('.datatable-actions').collapse('hide');
            }
        });

        datatable.on('datatable-on-reloaded', function (e) {
            $('.datatable-actions').collapse('hide');
        });
    };

    return {
        // public functions
        init: function () {
            initDatatable();
        }
    };
})();

jQuery(document).ready(function () {
    user_datatable.init();
});

$('#user-multiple-delete-form').on('submit', function (e) {
    e.preventDefault();

    $('#multiple-delete-modal').modal('hide');

    var formData = new FormData(this);
    var ids = datatable.checkbox().getSelectedId();

    ids.forEach(function (id) {
        formData.append('ids[]', id);
    });

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function (data) {
            toastr.success('کاربران انتخاب شده با موفقیت حذف شدند.');
            datatable.reload();
        },
        beforeSend: function (xhr) {
            block('#main-card');
            xhr.setRequestHeader(
                'X-CSRF-TOKEN',
                $('meta[name="csrf-token"]').attr('content')
            );
        },
        complete: function () {
            unblock('#main-card');
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$('#users-export-form').on('submit', function (e) {
    e.preventDefault();

    let formData = datatable.getDataSourceParam();
    let queryString = $.param(formData);

    let formData2 = new FormData(this);
    let queryString2 = new URLSearchParams(formData2).toString();

    let url = `${$(this).attr('action')}?${queryString}&${queryString2}`;

    window.open(url);
});
