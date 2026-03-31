$(document).on('click', '.show-sms', function () {
    var btn = $(this);

    $.ajax({
        url: $(this).data('action'),
        type: 'GET',
        success: function (data) {
            $('#sms-detail').empty();
            $('#sms-detail').append(data);
            $('#show-modal').modal('show');
        },
        beforeSend: function (xhr) {
            block(btn);
        },
        complete: function () {
            unblock(btn);
        }
    });
});
