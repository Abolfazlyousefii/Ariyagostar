$(document).on('click', '.btn-delete', function () {
    $('#widget-delete-form').attr('action', $(this).data('action'));
});

$('#widget-delete-form').submit(function (e) {
    e.preventDefault();

    $('#delete-modal').modal('hide');

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function (data) {
            if (data == 'success') {
                //get current url
                var url = window.location.href;

                toastr.success('ابزارک با موفقیت حذف شد.');

                //refresh widgets list
                $(".app-content").load(url + " .app-content > *", sortable);
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

function sortable() {
    $('tbody').sortable({
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
            saveChanges();
        },
    });
}

function saveChanges() {

    var sortedIDs = $("#widgets-sortable").sortable("toArray");

    if (!sortedIDs.length) {
        return;
    }

    sortedIDs.forEach(function (value, index) {
        sortedIDs[index] = value.replace('widget-', '');
    });

    $.ajax({
        url: $('#widgets-sortable').data('action'),
        type: 'post',
        data: { widgets: sortedIDs },
        success: function () {
            //
        },
        beforeSend: function (xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        complete: function () {
            //
        },
    });
}

sortable();
