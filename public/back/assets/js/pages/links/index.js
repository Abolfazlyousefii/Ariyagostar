$(document).on('click', '.btn-delete', function() {
    $('#link-delete-form').attr('action', BASE_URL + '/links/' + $(this).data('link'));
    $('#link-delete-form').data('id', $(this).data('link'));
});

$('#link-delete-form').submit(function(e) {
    e.preventDefault();

    $('#delete-modal').modal('hide');

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function(data) {
            //get current url
            var url = window.location.href;

            //remove link tr
            $('#link-' + $('#link-delete-form').data('id')).remove();

            toastr.success('لینک با موفقیت حذف شد.');

            //refresh links list
            $(".app-content").load(url + " .app-content > *");

            setTimeout(function() {
                events();
            }, 1000);
        },
        beforeSend: function(xhr) {
            block('#main-card');
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        complete: function() {
            unblock('#main-card');
        },
        cache: false,
        contentType: false,
        processData: false
    });

});

var events = function() {
    var sortable = $('tbody').sortable({
        opacity: .75,
        handle: '.draggable-handler',
        start: function(e, ui) {
            ui.placeholder.css({
                'height': ui.item.outerHeight(),
                'margin-bottom': ui.item.css('margin-bottom'),
            });
        },
        helper: function(e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function(index) {
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        },

        update: function() {
            $('.links-sortable').each(function(index, e) {
                saveChanges(index);
            });
        },
    });
}

events();

function saveChanges(group) {

    var sortedIDs = $("#links-sortable-" + group).sortable("toArray");

    if (!sortedIDs.length) {
        return;
    }

    sortedIDs.forEach(function(value, index) {
        sortedIDs[index] = value.replace('link-', '');
    });

    $.ajax({
        url: BASE_URL + '/links/sort',
        type: 'post',
        data: { links: sortedIDs },
        success: function() {
            //
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