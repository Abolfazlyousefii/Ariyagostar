$('#category').select2({
    rtl: true,
    width: '100%',
});

$('#edit-category').select2({
    rtl: true,
    width: '100%',
});


$(".create-menu-link, .edit-menu-link").autocomplete({
    source: pages
});

$(".create-menu-link").autocomplete("option", "appendTo", "#create-menu");
$(".edit-menu-link").autocomplete("option", "appendTo", "#edit-form");

var nestable = $('.dd').nestable({
    maxDepth: 10,
    callback: function() {
        if (JSON.stringify($('.dd').nestable('serialize')) != JSON.stringify(menus)) {
            $('#save-changes').prop('disabled', false);
            saveChanges();
        }
    },
    onDragStart: function(l, e) {
        var nochildren = ['.dd-static'];

        if ($(e).children().find('.dd-item').length > 0) {
            var $target = $(e).children().find('.dd-item');

            while ($target.length > 1) {
                $target = $target.children().find('.dd-item');
            }

            var selectedLenght = $($target[0]).parentsUntil($(e), '.dd-item').length + 1;
        } else {
            var selectedLenght = 0;
        }

        $('.dd-item').each(function(index, el) {
            if ($(el).parents('.dd-item').last().data('category-type') == 'megamenu' || $(el).data('category-type') == 'megamenu') {
                if ($(el).parents('.dd-item').length + selectedLenght >= megaMenuDepth) {
                    $(el).addClass('dd-nochildren');
                    nochildren.push(el);
                }
            }
        });

        if ($(e).data('static') || $(e).data('category-type') == 'megamenu') {
            $('.dd-item').addClass('dd-nochildren');
        } else {
            $('.dd-item').removeClass('dd-nochildren');

            nochildren.forEach(function(item) {
                $(item).addClass('dd-nochildren');
            });
        }
    },

    beforeDragStop: function(l, e, p) {
        if (!$(".dd-placeholder").is(":visible")) {
            return false;
        }
    }

});

var menus = $('.dd').nestable('serialize');

$.ajaxSetup({
    beforeSend: function(xhr) {
        xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        block('#main-block');
    },
    complete: function() {
        unblock('#main-block');
    },
});

$('#menu-type').on('change', function() {
    var type = $(this).val();

    switch (type) {
        case 'normal':
        case 'megamenu':
            {
                $('#menu-category-div, #menu-static-div').hide();
                $('#menu-title-div, #menu-link-div').show();
                break;
            }

        case 'category':
            {
                $('#menu-title-div, #menu-link-div, #menu-static-div').hide();
                $('#menu-category-div').show();
                break;
            }
        case 'static':
            {
                $('#menu-category-div, #menu-link-div').hide();
                $('#menu-title-div, #menu-static-div').show();
                break;
            }

    }
});

$('#edit-menu-type').on('change', function() {
    var type = $(this).val();

    switch (type) {
        case 'normal':
        case 'megamenu':
            {
                $('#edit-menu-category-div, #edit-menu-static-div').hide();
                $('#edit-menu-title-div, #edit-menu-link-div').show();
                break;
            }

        case 'category':
            {
                $('#edit-menu-title-div, #edit-menu-link-div, #edit-menu-static-div').hide();
                $('#edit-menu-category-div').show();
                break;
            }
        case 'static':
            {
                $('#edit-menu-category-div, #edit-menu-link-div').hide();
                $('#edit-menu-title-div, #edit-menu-static-div').show();
                break;
            }
    }
});

$('#create-menu').submit(function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: BASE_URL + '/menus',
        type: 'post',
        data: formData,
        success: function(data) {
            jQuery('#modal-add').modal('hide');

            $('.dd-empty').remove();

            if (data.menu.type == 'static') {
                $('.dd').nestable('add', { "id": data.menu.id, "content": '<span class="menu-title">' + data.title + '</span><a data-menu="' + data.menu.id + '" class="float-right delete-menu dd-nodrag" href="javascript:void(0)"><i class="fa fa-trash text-danger px-1"></i>حذف</a><a data-menu="' + data.menu.id + '"  class="float-right edit-menu dd-nodrag" href="javascript:void(0)"><i class="fa fa-pencil text-info px-1"></i>ویرایش</a>' });

                var item = $('a[data-menu=' + data.menu.id + ']').closest('.dd-item');

                item.addClass('dd-static');
                item.data('static', true);

            } else {
                $('.dd').nestable('add', { "id": data.menu.id, "content": '<span class="menu-title">' + data.title + '</span><a data-menu="' + data.menu.id + '" class="float-right delete-menu dd-nodrag" href="javascript:void(0)"><i class="fa fa-trash text-danger px-1"></i>حذف</a><a data-menu="' + data.menu.id + '"  class="float-right edit-menu dd-nodrag" href="javascript:void(0)"><i class="fa fa-pencil text-info px-1"></i>ویرایش</a>' });
            }

            $('a[data-menu=' + data.menu.id + ']').closest('.dd-item').data('category-type', data.menu.type);

            $('#create-menu').trigger('reset');
            $('#menu-type, #category').trigger('change');

            menus = $('.dd').nestable('serialize');
        },
        beforeSend: function(xhr) {
            block('#modal-add .modal-content');
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        complete: function() {
            unblock('#modal-add .modal-content');
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$(document).on('click', '.delete-menu', function() {
    $('#confirm-delete').data('menu', $(this).data('menu'));
    jQuery('#modal-delete').modal('show');
});

$(document).on('click', '.edit-menu', function() {
    var menu = $(this).data('menu');

    $.ajax({
        url: BASE_URL + '/menus/' + menu,
        type: 'get',
        success: function(data) {

            if (data.menu.type == 'static') {
                $('.not-static').hide();
                $('#edit-menu-title-div, #edit-menu-static-div').show();
            } else {
                $('.not-static').show();
            }
            $('#edit-form #edit-menu-type').val(data.menu.type);
            $('#edit-form input[name="title"]').val(data.menu.title);
            $('#edit-form input[name="category_title"]').val(data.menu.title);
            $('#edit-form input[name="link"]').val(data.menu.link);
            $('#edit-form input[name="children"]').prop('checked', data.menu.children);

            if (data.menu.type == 'category') {
                $('#edit-form #edit-category').val(data.menu.category.id);
            }

            $('#edit-form').data('menu', menu);
            $('#edit-menu-type, #edit-category').trigger('change');
            jQuery('#modal-edit').modal('show');
        },
    });
});


$('#edit-form').submit(function(e) {
    e.preventDefault();

    var menu = $(this).data('menu');
    var formData = new FormData(this);

    $.ajax({
        url: BASE_URL + '/menus/' + menu,
        type: 'post',
        data: formData,
        success: function(data) {
            jQuery('#modal-edit').modal('hide');

            $('a[data-menu=' + menu + ']').closest('.dd-handle').find('.menu-title').text(data.title);

            var item = $('a[data-menu=' + data.menu.id + ']').closest('.dd-item');

            if (data.menu.type == 'static') {

                item.addClass('dd-static');
                item.data('static', true);
            } else {
                item.removeClass('dd-static');
                item.data('static', false);
            }
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

$('#confirm-delete').click(function() {

    jQuery('#modal-delete').modal('hide');

    var menu = $(this).data('menu');

    $.ajax({
        url: BASE_URL + '/menus/' + menu,
        type: 'post',
        data: {
            _method: 'DELETE',
        },
        success: function() {
            $('.dd').nestable('remove', menu);

            Swal.fire({
                text: "منو با موفقیت حذف شد",
                type: 'success',
                confirmButtonText: 'باشه',
            });

            menus = $('.dd').nestable('serialize');
        }
    });

});

function saveChanges() {

    if (!menus.length) {
        return;
    }

    $.ajax({
        url: BASE_URL + '/menus/sort',
        type: 'post',
        data: { menus: $('.dd').nestable('serialize') },
        success: function() {
            menus = $('.dd').nestable('serialize');
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
