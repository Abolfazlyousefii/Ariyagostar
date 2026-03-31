"use strict";
// Class definition

var datatable;

var city_datatable = function () {
    // Private functions

    var options = {
        // datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    url: $('#cities_datatable').data('action'),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    map: function (raw) {
                        // sample data mapping
                        var dataSet = raw;
                        if (typeof raw.data !== 'undefined') {
                            dataSet = raw.data;
                        }
                        return dataSet;
                    },
                    params: {
                        query: $('#filter-cities-form').serializeJSON()
                    }
                },
            },
            pageSize: 10,
            serverPaging: true,
            serverFiltering: true,
            serverSorting: true,
        },

        layout: {
            scroll: true
        },

        rows: {
            autoHide: false,
            afterTemplate: function (row, data, index) {
                $(row).attr('sortable-id', data.id);
                $(row).attr('sortable-ordering', data.ordering);
            }
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
                textAlign: 'center',
            },
            {
                field: 'order',
                sortable: false,
                width: 20,
                title: '',
                template: function (row) {
                    return '<span class="draggable-handler"><i class="feather icon-move"></i></span>';
                }
            },
            {
                field: 'ordering',
                title: 'ترتیب',
                sortable: 'asc',
                template: function (row) {
                    return row.ordering;
                }
            },
            {
                field: 'name',
                title: 'نام',
                template: function (row) {
                    return row.name;
                }
            },
            {
                field: 'is_active',
                title: 'وضعیت',
                template: function (row) {
                    return row.is_active ? 'فعال' : 'غیرفعال';
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
                    return '<a href ="' + row.links.edit + '"class="btn btn-warning waves-effect waves-light">ویرایش</a>';

                },
            },
        ],
    };

    var initDatatable = function () {
        // enable extension
        options.extensions = {
            // boolean or object (extension options)
            checkbox: true,
        };

        datatable = $('#cities_datatable').KTDatatable(options);

        $('#filter-cities-form .datatable-filter').on('change', function () {
            formDataToUrl('filter-cities-form');
            datatable.setDataSourceQuery($('#filter-cities-form').serializeJSON());
            datatable.reload();
        });

        datatable.on('datatable-on-click-checkbox',
            function (e) {
                var ids = datatable.checkbox().getSelectedId();
                var count = ids.length;

                $('#datatable-selected-rows').html(count);

                if (count > 0) {
                    $('.datatable-actions').collapse('show');
                } else {
                    $('.datatable-actions').collapse('hide');
                }
            }
        );

        datatable.on('datatable-on-reloaded',
            function (e) {
                $('.datatable-actions').collapse('hide');
            }
        );

        datatable.on('datatable-on-layout-updated',
            function (e) {
                setTimeout(() => {
                    sortableTable();
                }, 100);
            }
        );
    };

    return {
        // public functions
        init: function () {
            initDatatable();
        },
    };
}();

jQuery(document).ready(function () {
    city_datatable.init();
});

$('#city-multiple-delete-form').on('submit', function (e) {
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
            if (data == 'success') {
                toastr.success('شهر های انتخاب شده با موفقیت حذف شدند.');
                datatable.reload();
            }
        },
        beforeSend: function (xhr) {
            block('#main-card');
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        complete: function () {
            unblock('#main-card');
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

// ----------------- sortable js codes
var sortable;

function sortableTable() {
    sortable = $('#cities_datatable tbody').sortable({
        opacity: .75,
        handle: '.draggable-handler',
        start: function (e, ui) {
            ui.placeholder.css({
                'height': ui.item.outerHeight(),
                'margin-bottom': ui.item.css('margin-bottom'),
            });
        },
        helper: function (e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function (index) {
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        },

        update: function () {
            saveSortableChanges();
        },
    });
}

function saveSortableChanges() {

    var sortedIDs = $('#cities_datatable tbody').sortable("toArray", {
        attribute: 'sortable-id'
    });

    var sortedOrdering = $('#cities_datatable tbody').sortable("toArray", {
        attribute: 'sortable-ordering'
    });

    if (!sortedIDs.length) {
        return;
    }

    sortedIDs = sortedIDs.filter((a) => a);
    sortedOrdering = sortedOrdering.filter((a) => a);

    $.ajax({
        url: $('#cities_datatable').data('sortable'),
        type: 'post',
        data: {
            cities: sortedIDs,
            orderings: sortedOrdering,
        },
        success: function () {
            datatable.reload();
        },
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
    });
}
