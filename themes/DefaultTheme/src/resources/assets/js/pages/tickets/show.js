jQuery('#ticket-update-form').validate({
    rules: {
        'message': {
            required: true,
        },
    },
});

$('#ticket-update-form').submit(function(e) {
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
                    text: 'پیام با موفقیت ثبت شد',
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'باشه',
                }).then(function() {
                    $('#ticket-update-form').data('disabled', true);
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

$(document).ready(function() {
    $(".msg_history").animate({ scrollTop: $('.msg_history').prop("scrollHeight") }, 1000);
});