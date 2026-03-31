jQuery('#ticket-create-form').validate({
    rules: {
        'subject': {
            required: true,
        },
        'message': {
            required: true,
        },
    },
});

$('#ticket-create-form').submit(function(e) {
    e.preventDefault();

    if ($(this).valid() && !$(this).data('disabled')) {

        var formData = new FormData(this);
        var form = $(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(data) {
                Swal.fire({
                    text: 'تیکت با موفقیت ایجاد شد',
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'باشه',
                }).then(function() {
                    $('#ticket-create-form').data('disabled', true);
                    window.location.href = form.data('redirect');
                });
            },

            beforeSend: function(xhr) {
                block(form);
                xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            },
            complete: function() {
                unblock(form);
            },

            cache: false,
            contentType: false,
            processData: false
        });
    }

});