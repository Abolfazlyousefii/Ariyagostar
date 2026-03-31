jQuery('#reset-form').validate({
    rules: {
        'prev_password': {
            required: true,
        },

        'password': {
            required: true,
            minlength: 8
        },

        'password_confirmation': {
            required: true,
            equalTo: "#password"
        },
    },
});


$('#reset-form').submit(function (e) {
    e.preventDefault();

    if ($(this).valid()) {
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                Swal.fire({
                    title: 'رمز عبور شما با موفقیت تغییر کرد',
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'باشه',
                    closeOnConfirm: false,
                    closeOnCancel: false
                }).then(() => {
                    window.location.href = redirect_url;
                });
               
            },
            beforeSend: function (xhr) {
                block('.form-ui');
                xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            },
            complete: function () {
                unblock('.form-ui');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
});
