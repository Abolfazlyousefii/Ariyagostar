'use strict';
// Class definition

var datatable;

var order_datatable = (function () {
    // Private functions

    var server_data;

    var options = {
        // datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    url: $('#orders_datatable').data('action'),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content'
                        )
                    },
                    map: function (raw) {
                        // sample data mapping
                        var dataSet = raw;
                        server_data = raw;

                        if (typeof raw.data !== 'undefined') {
                            dataSet = raw.data;
                        }

                        return dataSet;
                    },
                    params: {
                        query: $('#filter-orders-form').serializeJSON()
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
                field: 'ordering',
                sortable: false,
                title: 'ردیف',
                width: 40,
                template: function (row, i) {
                    let number =
                        parseInt(
                            server_data.meta.perpage *
                                (server_data.meta.current_page - 1)
                        ) +
                        parseInt(i) +
                        1;
                    return number;
                }
            },
            {
                field: 'name',
                title: 'نام سفارش دهنده'
            },
            {
                field: 'order_id',
                title: 'شماره سفارش'
            },
            {
                field: 'created_at',
                sortable: 'desc',
                title: 'تاریخ ثبت سفارش',
                template: function (row) {
                    return '<span class="ltr">' + row.created_at + '</span>';
                }
            },
            {
                field: 'price',
                title: 'قیمت کل'
            },
            {
                field: 'shipping_status',
                title: 'وضعیت ارسال',
                sortable: false,
                template: function (row) {
                    return `<span class="badge badge-info">${row.shipping_status}</span>`;
                }
            },
            {
                field: 'status',
                title: 'وضعیت',
                textAlign: 'center',
                // callback function support for column rendering
                template: function (row) {
                    var status = {
                        canceled: {
                            title: 'لغو شده',
                            class: ' badge-danger'
                        },
                        unpaid: {
                            title: 'پرداخت نشده',
                            class: ' badge-danger'
                        },
                        paid: {
                            title: 'پرداخت شده',
                            class: ' badge-success'
                        }
                    };
                    return (
                        '<div class="badge badge-pill ' +
                        status[row.status].class +
                        ' badge-md">' +
                        status[row.status].title +
                        '</div>'
                    );
                }
            },

            {
                field: 'actions',
                title: 'عملیات',
                sortable: false,
                width: 125,
                overflow: 'visible',
                autoHide: false,
                template: function (row) {
                    return (
                        '<a href="' +
                        row.links.view +
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

        datatable = $('#orders_datatable').KTDatatable(options);

        $('#filter-orders-form .datatable-filter').on('change', function () {
            formDataToUrl('filter-orders-form');
            datatable.setDataSourceQuery(
                $('#filter-orders-form').serializeJSON()
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
    order_datatable.init();
});

$('#order-multiple-delete-form').on('submit', function (e) {
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
            toastr.success('سفارشات انتخاب شده با موفقیت حذف شدند.');
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

$('#multiple-shipping-status-change').on('submit', function (e) {
    e.preventDefault();

    $('#shiping-status-change').modal('hide');

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
            toastr.success('سفارشات انتخاب شده با موفقیت تغیر وضعیت  شدند.');
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

$('#print-all-btn').on('click', function (e) {
    let ids = datatable.checkbox().getSelectedId();
    let url = $(this).data('action') + '?';

    ids.forEach(function (id) {
        url += 'ids[]=' + id + '&';
    });

    window.open(url);
});

$('#print-all-shipping').on('click', function (e) {
    let ids = datatable.checkbox().getSelectedId();
    let url = $(this).data('action') + '?';

    ids.forEach(function (id) {
        url += 'ids[]=' + id + '&';
    });

    window.open(url);
});

$('#print-all-factor-btn').on('click', function (e) {
    let ids = datatable.checkbox().getSelectedId();
    let url = $(this).data('action') + '?';

    ids.forEach(function (id) {
        url += 'ids[]=' + id + '&';
    });

    window.open(url);
});

$('#orders-export-form').on('submit', function (e) {
    e.preventDefault();

    let formData = datatable.getDataSourceParam();
    let queryString = $.param(formData);

    let formData2 = new FormData(this);
    let queryString2 = new URLSearchParams(formData2).toString();

    let url = `${$(this).attr('action')}?${queryString}&${queryString2}`;

    window.open(url);
});
