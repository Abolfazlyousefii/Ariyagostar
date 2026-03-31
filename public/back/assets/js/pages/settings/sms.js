$(document).ready(function () {
    jQuery('#sms-form').validate();

    $('#sms-form').submit(function (e) {
        e.preventDefault();

        if ($(this).valid()) {
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function (data) {
                    Swal.fire({
                        type: 'success',
                        title: 'تغییرات با موفقیت ذخیره شد',
                        confirmButtonClass: 'btn btn-primary',
                        confirmButtonText: 'باشه',
                        buttonsStyling: false
                    });
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

    $(document).on('change', '#sms-form input[data-class!=""]', function () {
        if ($(this).prop('checked')) {
            $('.' + $(this).data('class')).prop('disabled', false);
        } else {
            $('.' + $(this).data('class')).prop('disabled', true);
        }
    });

    $('#sms-form input[data-class!=""]').trigger('change');
});

$('#sms-panel-provider').on('change', function () {
    $('.sms-panel-fields').hide();

    if ($(this).val() == 'ippanel') {
        $('#ippannel-sms-fields').show();
    } else if ($(this).val() == 'kavenegar') {
        $('#kavenegar-sms-fields').show();
    }else if ($(this).val() == 'idehpardazan') {
        $('#idehpardazan-sms-fields').show();
    } else {
        $('#melipayamak-sms-fields').show();
    }
});
