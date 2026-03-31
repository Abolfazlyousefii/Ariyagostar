'use strict';
// Class definition

var datatable;

var product_datatable = (function () {
    // Private functions

    var options = {
        // datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    url: $('#products_datatable').data('action'),
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
                        query: $('#filter-products-form').serializeJSON()
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
                field: 'productid',
                sortable: false,
                width: 50,
                title: 'ID',
                template: function (row) {
                    return row.id;
                }
            },
            {
                field: 'image',
                title: 'تصویر شاخص',
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
                field: 'title',
                title: 'عنوان محصول',
                width: 200,
                template: function (row) {
                    return row.title;
                }
            },
            {
                field: 'created_at',
                sortable: 'desc',
                title: 'تاریخ ایجاد',
                template: function (row) {
                    return '<span class="ltr">' + row.created_at + '</span>';
                }
            },
            {
                field: 'admin_updated_at',
                sortable: 'desc',
                title: 'تاریخ ویرایش',
                template: function (row) {
                    return (
                        '<span class="ltr">' + row.admin_updated_at + '</span>'
                    );
                }
            },
            {
                field: 'addableToCart',
                title: 'تعداد موجودی',
                textAlign: 'center',
                width: 100,
                // callback function support for column rendering
                template: function (row) {
                    if (row.addableToCart) {
                        var addableToCartClass = '';
                        var addableToCartText = `${row.stock_count}`;
                    } else {
                        var addableToCartClass = 'text-danger';
                        var addableToCartText = 'ناموجود';
                    }
                    return `<div class="text text-pill ${addableToCartClass}">${addableToCartText}</div>`;
                }
            },
            {
                field: 'published',
                title: 'وضعیت انتشار',
                textAlign: 'center',
                width: 80,
                // callback function support for column rendering
                template: function (row) {
                    if (row.published) {
                        var publishedClass = 'badge-success';
                        var publishedText = 'منتشر شده';
                    } else {
                        var publishedClass = 'badge-danger';
                        var publishedText = 'پیش نویس';
                    }
                    return (
                        '<div class="badge badge-pill ' +
                        publishedClass +
                        ' badge-md">' +
                        publishedText +
                        '</div>'
                    );
                }
            },
            {
                field: 'actions',
                title: 'عملیات',
                textAlign: 'center',
                sortable: false,
                width: 150,
                overflow: 'visible',
                autoHide: false,
                template: function (row) {
                    return (
                        '<a href ="' +
                        row.links.edit +
                        '"class="btn btn-warning waves-effect waves-light">ویرایش</a>\
                    <button data-toggle="modal" data-target="#delete-modal" data-action="' +
                        row.links.destroy +
                        '" class="btn btn-danger waves-effect waves-light btn-delete">حذف</button>'
                    );
                }
            },
            {
                field: 'quickActions',
                title: '',
                textAlign: 'center',
                sortable: false,
                width: 50,
                template: function (row) {
                    return (
                        '<a title="کپی کردن" href="' +
                        row.links.copy +
                        '" target="_blank"><i class="feather icon-copy"></i></a>\
                    <a title="مشاهده" href="' +
                        row.links.front +
                        '" target="_blank"><i class="feather icon-external-link"></i></a>'
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

        datatable = $('#products_datatable').KTDatatable(options);

        $('#filter-products-form .datatable-filter').on('change', function () {
            formDataToUrl('filter-products-form');
            datatable.setDataSourceQuery(
                $('#filter-products-form').serializeJSON()
            );
            datatable.reload();
        });

        datatable.on('datatable-on-click-checkbox', function (e) {
            var ids = datatable.checkbox().getSelectedId();
            var count = ids.length;

            $('.selected_product_ids').empty();

            ids.forEach(function (id) {
                $('.selected_product_ids').append(
                    `<option value="${id}" selected>${id}</option>`
                );
            });
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
    product_datatable.init();
});

$(document).on('click', '.btn-delete', function () {
    $('#product-delete-form').attr('action', $(this).data('action'));
});

$('#product-delete-form').on('submit', function (e) {
    e.preventDefault();

    $('#delete-modal').modal('hide');

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function (data) {
            toastr.success('محصول با موفقیت حذف شد.');
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

$('#product-multiple-delete-form, #product-multiple-unavailable-form').on(
    'submit',
    function (e) {
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
                toastr.success('با موفقیت انجام شد.');
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
    }
);

$('#products-export-form').on('submit', function (e) {
    e.preventDefault();

    let formData = datatable.getDataSourceParam();
    let queryString = $.param(formData);

    let formData2 = new FormData(this);
    let queryString2 = new URLSearchParams(formData2).toString();

    let url = `${$(this).attr('action')}?${queryString}&${queryString2}`;

    window.open(url);
});

$('select[name="export_type"]').on('change', function () {
    $('.export-options').hide();
    $(`.export-options[data-export-type="${$(this).val()}"]`).show();
});
