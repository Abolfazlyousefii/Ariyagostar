// validate form with jquery validation plugin
jQuery('#currency-edit-form').validate({
    rules: {
        amount: {
            required: true
        },
        title: {
            required: true
        }
    }
});

$('#currency-edit-form').submit(function (e) {
    e.preventDefault();
    var form = $(this);

    if ($(this).valid() && !$(this).data('disabled')) {
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                if (data == 'success') {
                    $('#currency-edit-form').data('disabled', true);
                    window.location.href = form.data('redirect');
                }
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
});
