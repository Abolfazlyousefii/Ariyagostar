$(document).ready(function() {
    // تابع کمکی برای ساخت مسیر با پیشوند درست
    function buildAdminUrl(path) {
        return BASE_URL + '/admin' + (adminRoutePrefix ? '/' + adminRoutePrefix : '') + path;
    }

    $('.dd').nestable({
        maxDepth: (typeof maxDepth !== 'undefined') ? maxDepth : 10,
        forceFallback: true,
        callback: function() {
            if (JSON.stringify($('.dd').nestable('serialize')) != JSON.stringify(categories)) {
                $('#save-changes').prop('disabled', false);
                saveChanges();
            }
        }
    });

    var categories = $('.dd').nestable('serialize');
    var hasBulkDelete = $('#bulk-delete-trigger').length > 0;

    function getSelectedCategoryIds() {
        return $('.category-bulk-checkbox:checked').map(function() {
            return Number($(this).val());
        }).get();
    }

    function getAllBulkCheckboxes() {
        return $('.category-bulk-checkbox');
    }

    function toggleBulkActionsVisibility() {
        if (!hasBulkDelete) {
            return;
        }

        if (getAllBulkCheckboxes().length) {
            $('#bulk-actions').show();
        } else {
            $('#bulk-actions').hide();
        }
    }

    function updateBulkActionsState() {
        if (!hasBulkDelete) {
            return;
        }

        var selectedIds = getSelectedCategoryIds();
        var allCount = getAllBulkCheckboxes().length;

        $('#selected-count').text(selectedIds.length + ' مورد انتخاب شده');
        $('#bulk-delete-trigger').prop('disabled', selectedIds.length === 0);

        if (allCount > 0 && selectedIds.length === allCount) {
            $('#select-all-categories').prop('checked', true);
            $('#select-all-categories').prop('indeterminate', false);
        } else if (selectedIds.length > 0) {
            $('#select-all-categories').prop('checked', false);
            $('#select-all-categories').prop('indeterminate', true);
        } else {
            $('#select-all-categories').prop('checked', false);
            $('#select-all-categories').prop('indeterminate', false);
        }
    }

    $('#create-category').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(this);

        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: formData,
            success: function(data) {
                $('.dd-empty').remove();
                var itemPrefix = '';

                if (hasBulkDelete) {
                    itemPrefix = '<span class="dd-nodrag mr-1" style="display: inline-flex; align-items: center;"><input type="checkbox" class="category-bulk-checkbox" value="' + data.id + '" aria-label="انتخاب دسته‌بندی ' + data.title + '"></span>';
                }

                $('.dd').nestable('add', {
                    "id": data.id,
                    "content": itemPrefix + '<span class="category-title">' + data.title + '</span><a data-category="' + data.slug + '" class="float-right delete-category dd-nodrag" href="javascript:void(0)" data-toggle="modal" data-target="#modal-delete"><i class="fa fa-trash text-danger px-1"></i>حذف</a><a data-category="' + data.slug + '" class="float-right edit-category dd-nodrag" href="javascript:void(0)"><i class="fa fa-pencil text-info px-1"></i>ویرایش</a>'
                });
                $('#create-category').trigger('reset');
                categories = $('.dd').nestable('serialize');
                toggleBulkActionsVisibility();
                updateBulkActionsState();
            },
            beforeSend: function(xhr) {
                block('#main-block');
                xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            },
            complete: function() {
                unblock('#main-block');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $(document).on('click', '.delete-category', function() {
        var category = $(this).data('category');
        $('#delete-form').attr('action', deleteRouteBase + '/' + category);
    });

    $(document).on('change', '#select-all-categories', function() {
        var checked = $(this).is(':checked');
        getAllBulkCheckboxes().prop('checked', checked);
        updateBulkActionsState();
    });

    $(document).on('change', '.category-bulk-checkbox', function() {
        updateBulkActionsState();
    });

    $(document).on('click', '#bulk-delete-trigger', function() {
        var selectedIds = getSelectedCategoryIds();

        if (!selectedIds.length) {
            if (typeof toastr !== 'undefined') {
                toastr.warning('حداقل یک دسته‌بندی را انتخاب کنید.');
            }
            return;
        }

        $('#modal-bulk-delete').modal('show');
    });

    $(document).on('click', '#confirm-bulk-delete', function() {
        var selectedIds = getSelectedCategoryIds();

        if (!selectedIds.length) {
            $('#modal-bulk-delete').modal('hide');
            if (typeof toastr !== 'undefined') {
                toastr.warning('هیچ دسته‌بندی انتخاب نشده است.');
            }
            return;
        }

        $.ajax({
            url: bulkDeleteRoute,
            type: 'post',
            data: {
                _method: 'DELETE',
                category_ids: selectedIds,
                type: $('input[name="type"]').first().val(),
            },
            success: function(response) {
                $('#modal-bulk-delete').modal('hide');
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.message);
                }
                window.location.reload();
            },
            error: function(xhr) {
                var message = 'حذف گروهی انجام نشد.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                if (typeof toastr !== 'undefined') {
                    toastr.error(message);
                }
            },
            beforeSend: function(xhr) {
                block('#main-block');
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            complete: function() {
                unblock('#main-block');
            },
        });
    });

    $(document).on('click', '.edit-category', function() {
        var category = $(this).data('category');

        $.ajax({
            url: buildAdminUrl('/categories/' + category + '/edit'),
            type: 'get',
            data: {},
            success: function(data) {
                $('#edit-form').attr('action', buildAdminUrl('/categories/' + category));
                $('#edit-form').data('category', category);
                $('#modal-edit .modal-body').html(data);
                jQuery('#modal-edit').modal('show');

                $('.tags').tagsInput({
                    'defaultText': 'افزودن',
                    'width': '100%',
                    'autocomplete_url': buildAdminUrl('/get-tags'),
                });

                if (typeof CKEDITOR !== 'undefined') {
                    CKEDITOR.replace('category-description');
                }

                $('#filter_type').trigger('change');
            },
            beforeSend: function(xhr) {
                block('#main-block');
            },
            complete: function() {
                unblock('#main-block');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $('#modal-edit').on('shown.bs.modal', function() {
        $('#edit-title').focus();
    });

    $('#edit-form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var form = $(this);
        var category = form.data('category');

        if (typeof CKEDITOR !== 'undefined') {
            formData.append('description', CKEDITOR.instances['category-description'].getData());
        }

        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: formData,
            success: function(data) {
                $('a[data-category=' + category + ']').closest('.dd-handle').find('.category-title').text(data.title);
                $('[data-category=' + category + ']').data('category', data.slug);
                $('[data-category=' + category + ']').attr('data-category', data.slug);
                jQuery('#modal-edit').modal('hide');
            },
            beforeSend: function(xhr) {
                block('#modal-edit .modal-content');
                xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            },
            complete: function() {
                unblock('#modal-edit .modal-content');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    function saveChanges() {
        if (!categories.length) {
            return;
        }

        $.ajax({
            url: buildAdminUrl('/categories/sort'),
            type: 'post',
            data: {
                categories: $('.dd').nestable('serialize'),
                type: $('input[name="type"]').first().val(),
            },
            success: function() {
                categories = $('.dd').nestable('serialize');
            },
            beforeSend: function(xhr) {
                xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
                $('#save-changes').show();
            },
            complete: function() {
                $('#save-changes').hide();
            },
        });
    }

    window.onbeforeunload = function() {
        if (!$('#save-changes').is(":hidden")) {
            return "Are you sure?";
        }
    };

    $(document).on('click', '#generate-category-slug', function(e) {
        e.preventDefault();
        var title = $('input[name="meta_title"]').val();

        $.ajax({
            url: buildAdminUrl('/category/slug'),
            type: 'POST',
            data: {
                title: title
            },
            success: function(data) {
                $('#slug').val(data.slug);
            },
            beforeSend: function(xhr) {
                xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
                $('#slug-spinner').show();
            },
            complete: function() {
                $('#slug-spinner').hide();
            }
        });
    });

    $(document).on('change', '#filter_type', function() {
        var filterType = $(this).val();
        if (filterType == 'filterId') {
            $('#filter_id').prop('disabled', false);
        } else {
            $('#filter_id').prop('disabled', true);
        }
    });

    toggleBulkActionsVisibility();
    updateBulkActionsState();
});
