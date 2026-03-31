jQuery('#login-form').validate({
    rules: {
        username: {
            required: true
        },
        password: {
            required: true
        }
    }
});

$(document).ready(function () {
    $('#login-form').submit(function (e) {
        e.preventDefault();

        if ($(this).valid()) {
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function (data) {
                    toastr.success(
                        'شما با موفقیت وارد حساب کاربری خود شدید.',
                        '',
                        {
                            positionClass: 'toast-bottom-left',
                            containerId: 'toast-bottom-left'
                        }
                    );

                    setTimeout(() => {
                        window.location.href = redirect_url;
                    }, 2000);
                },

                beforeSend: function (xhr) {
                    block('.form-ui');
                    xhr.setRequestHeader(
                        'X-CSRF-TOKEN',
                        $('meta[name="csrf-token"]').attr('content')
                    );
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
});
