$(document).on('click', '.btn-delete', function () {
    $('#attribute-delete-form').attr(
        'action',
        BASE_URL + '/attributes/' + $(this).data('attribute')
    );
    $('#attribute-delete-form').data('id', $(this).data('id'));
});

$('#attribute-delete-form').submit(function (e) {
    e.preventDefault();

    $('#delete-modal').modal('hide');

    var form = this;
    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function (data) {
            //get current url
            var url = window.location.href;

            //remove attribute tr
            $('#attribute-' + $(form).data('id')).remove();

            toastr.success('ویژگی با موفقیت حذف شد.');

            //refresh attributes list
            $('.app-content').load(url + ' .app-content > *');
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

var sortable = $('tbody').sortable({
    opacity: 0.75,
    handle: '.draggable-handler',
    start: function (e, ui) {
        ui.placeholder.css({
            height: ui.item.outerHeight(),
            'margin-bottom': ui.item.css('margin-bottom')
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
        var sortedIDs = $('#attributes-sortable').sortable('toArray');

        if (!sortedIDs.length) {
            return;
        }

        sortedIDs.forEach(function (value, index) {
            sortedIDs[index] = value.replace('attribute-', '');
        });

        $.ajax({
            url: BASE_URL + '/attribute/sort',
            type: 'post',
            data: {attributes: sortedIDs},
            success: function () {
                //
            },
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    'X-CSRF-TOKEN',
                    $('meta[name="csrf-token"]').attr('content')
                );
                $('#save-changes').show();
            },
            complete: function () {
                $('#save-changes').hide();
            }
        });
    }
});

window.onbeforeunload = function () {
    if (!$('#save-changes').is(':hidden')) {
        return 'Are you sure?';
    }
};
