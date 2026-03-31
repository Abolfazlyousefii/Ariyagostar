$(document).on('click', '.btn-delete', function() {
    $('#slider-delete-form').attr('action', BASE_URL + '/sliders/' + $(this).data('slider'));
    $('#slider-delete-form').data('id', $(this).data('slider'));
});

$('#slider-delete-form').submit(function(e) {
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

            //remove slider tr
            $('#slider-' + $('#slider-delete-form').data('id')).remove();

            toastr.success('اسلایدر با موفقیت حذف شد.');

            //refresh sliders list
            $(".app-content").load(url + " .app-content > *");
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
        $('.sliders-sortable').each(function(index, e) {
            saveChanges(index);
        });
    },
});

function saveChanges(group) {

    var sortedIDs = $("#sliders-sortable-" + group).sortable("toArray");

    if (!sortedIDs.length) {
        return;
    }

    sortedIDs.forEach(function(value, index) {
        sortedIDs[index] = value.replace('slider-', '');
    });

    $.ajax({
        url: BASE_URL + '/sliders/sort',
        type: 'post',
        data: { sliders: sortedIDs },
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