$.validator.addMethod(
    'regex',
    function (value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
    },
    'لطفا یک مقدار معتبر وارد کنید'
);

jQuery('#profile-form').validate({
    rules: {
        first_name: {
            required: true
        },
        last_name: {
            required: true
        },
        mobile: {
            required: true,
            regex: '(09)[0-9]{9}'
        },
        postal_code: {
            required: true,
            digits: true,
            maxlength: 10,
            minlength: 10
        },
        province_id: {
            required: true
        },
        city_id: {
            required: true
        },
        address: {
            required: true,
            maxlength: 300
        }
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

$('#profile-form').submit(function (e) {
    e.preventDefault();

    if ($(this).valid()) {
        var formData = new FormData(this);
        var btn = $('#submit-btn');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                Swal.fire({
                    title: 'تغییرات با موفقیت ثبت شد',
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'باشه',
                    closeOnConfirm: false,
                    closeOnCancel: false
                });
            },
            beforeSend: function (xhr) {
                block(btn);
                xhr.setRequestHeader(
                    'X-CSRF-TOKEN',
                    $('meta[name="csrf-token"]').attr('content')
                );
            },
            complete: function () {
                unblock(btn);
            },

            cache: false,
            contentType: false,
            processData: false
        });
    }
});

$('#birthday').on('keydown keyup', function (e) {
    $(this).val('');
});

$('#birthday').jdatepicker({
    date: $('#birthday').val()
        ? moment($('#birthday').val(), 'jYYYY/jMM/jDD')
        : moment(),
    theme: jdatepicker.theme.bs4,
    format: 'jYYYY/jMM/jDD',
    fullWidth: false,
    minWidth: '200px',
    footer: false,
    month: true,
    year: true,
    value: ''
});

if (!$('#birthday').data('prev-value')) {
    $('#birthday').trigger('keydown');
}
