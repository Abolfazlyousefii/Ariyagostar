jQuery('#register-form').validate({
    rules: {
        first_name: {
            required: true
        },
        last_name: {
            required: true
        },
        email: {
            required: true,
            email: true
        },
        username: {
            required: true
        },

        password: {
            required: true,
            minlength: 8
        },

        password_confirmation: {
            required: true,
            equalTo: '#password'
        }
    }
});

$('#register-form').submit(function (e) {
    e.preventDefault();

    if ($(this).valid()) {
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                if (data == 'success') {
                    toastr.success('ثبت نام شما با موفقیت انجام شد.', '', {
                        positionClass: 'toast-bottom-left',
                        containerId: 'toast-bottom-left'
                    });

                    setTimeout(() => {
                        window.location.href = redirect_url;
                    }, 2000);
                }
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

$.validator.addMethod(
    'regex',
    function (value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
    },
    'لطفا یک مقدار معتبر وارد کنید'
);

$('#birthday').on('keydown keyup', function (e) {
    $(this).val('');
});

$('#birthday').jdatepicker({
    theme: jdatepicker.theme.bs4,
    format: 'jYYYY/jMM/jDD',
    fullWidth: true,
    minWidth: '200px',
    footer: false,
    month: true,
    year: true,
    value: ''
});

$('#birthday').trigger('keydown');
