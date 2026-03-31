$('.dd').nestable({
    maxDepth: 10,
    callback: function() {
        if (JSON.stringify($('.dd').nestable('serialize')) != JSON.stringify(categories)) {
            $('#save-changes').prop('disabled', false);
            saveChanges();
        }
    }
});

var categories = $('.dd').nestable('serialize');

$.ajaxSetup({
    beforeSend: function(xhr) {
        xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        block('#main-block');
    },
    complete: function() {
        unblock('#main-block');
    },
});

$('#create-category').submit(function(e) {
    e.preventDefault();

    var title = $('#title').val();
    if (!title) {
        return;
    }

    $.ajax({
        url: BASE_URL + '/blogcats',
        type: 'post',
        data: {
            title: title,
        },
        success: function(data) {
            $('.dd-empty').remove();
            $('.dd').nestable('add', { "id": data.id, "content": '<span class="category-title">' + data.title + '</span><a data-category="' + data.id + '" class="float-right delete-category dd-nodrag" href="javascript:void(0)"><i class="fa fa-trash text-danger px-1"></i>حذف</a><a data-category="' + data.id + '"  class="float-right edit-category dd-nodrag" href="javascript:void(0)"><i class="fa fa-pencil text-info px-1"></i>ویرایش</a>' });
            $('#create-category').trigger('reset');

            categories = $('.dd').nestable('serialize');
        }
    });
});

$(document).on('click', '.delete-category', function() {
    $('#confirm-delete').data('category', $(this).data('category'));
    jQuery('#modal-delete').modal('show');
});

$(document).on('click', '.edit-category', function() {
    var title = $(this).closest('.dd-handle').find('.category-title').text();
    var category = $(this).data('category');

    $('#edit-title').val(title).focus();
    $('#edit-form').data('category', category);

    jQuery('#modal-edit').modal('show');
});


$('#modal-edit').on('shown.bs.modal', function() {
    $('#edit-title').focus();
});

$('#edit-form').submit(function(e) {
    e.preventDefault();

    var category = $(this).data('category');
    var title = $('#edit-title').val();

    if (!title) {
        return;
    }

    jQuery('#modal-edit').modal('hide');

    $.ajax({
        url: BASE_URL + '/blogcats/' + category,
        type: 'post',
        data: {
            _method: 'PUT',
            title: title
        },
        success: function(data) {
            $('a[data-category=' + category + ']').closest('.dd-handle').find('.category-title').text(data);
        }
    });

});

$('#confirm-delete').click(function() {

    jQuery('#modal-delete').modal('hide');

    var category = $(this).data('category');

    $.ajax({
        url: BASE_URL + '/blogcats/' + category,
        type: 'post',
        data: {
            _method: 'DELETE',
        },
        success: function() {
            $('.dd').nestable('remove', category);

            Swal.fire({
                text: "دسته بندی با موفقیت حذف شد",
                type: 'success',
                confirmButtonText: 'باشه',
            });

            categories = $('.dd').nestable('serialize');
        }
    });

});

function saveChanges() {

    if (!categories.length) {
        return;
    }

    $.ajax({
        url: BASE_URL + '/blogcats/sort',
        type: 'post',
        data: { categories: $('.dd').nestable('serialize') },
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