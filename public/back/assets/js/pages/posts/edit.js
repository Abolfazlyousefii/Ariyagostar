CKEDITOR.replace('content');

$('#tags').tagsInput({
    defaultText: 'افزودن',
    width: '100%',
    autocomplete_url: BASE_URL + '/get-tags'
});

$('#category').select2({
    rtl: true,
    width: '100%'
});

// validate form with jquery validation plugin
jQuery('#post-edit-form').validate({
    errorClass: 'invalid-feedback animated fadeInDown',
    errorPlacement: function (error, e) {
        jQuery(e).parents('.form-group').append(error);
    },
    highlight: function (e) {
        jQuery(e)
            .closest('.form-group')
            .find('input')
            .removeClass('is-invalid')
            .addClass('is-invalid');
    },
    success: function (e) {
        jQuery(e)
            .closest('.form-group')
            .find('input')
            .removeClass('is-invalid');
        jQuery(e).remove();
    },
    invalidHandler: function (form, validator) {
        if (!validator.numberOfInvalids()) return;

        $('html, body').animate(
            {
                scrollTop: $(validator.errorList[0].element).offset().top - 150
            },
            200
        );

        $(validator.errorList[0].element).focus();
    },
    rules: {
        title: {
            required: true
        }
    },
    messages: {
        title: {
            required: 'لطفا عنوان پست را وارد کنید'
        }
    }
});

$('#post-edit-form').submit(function (e) {
    e.preventDefault();

    if ($(this).valid() && !$(this).data('disabled')) {
        var date = $('#publish_date').val();
        $('#publish_date').val(date.toEnglishDigit());

        var formData = new FormData(this);
        formData.append('content', CKEDITOR.instances['content'].getData());

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                $('#post-edit-form').data('disabled', true);
                window.location.href = BASE_URL + '/posts';
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

var publishDatePicker;

jQuery(function () {
    publishDatePicker = $('#publish_date_picker').pDatepicker({
        timePicker: {
            enabled: true,
            meridian: {
                enabled: false
            },
            second: {
                enabled: false
            }
        },
        toolbox: {
            // enabled: true,
            calendarSwitch: {
                enabled: false
            }
        },
        initialValue: false,
        initialValueType: 'persian',
        altField: '#publish_date',
        altFormat: 'YYYY-MM-DD HH:mm:ss',

        onSelect: function (unixDate) {
            var date = $('#publish_date').val();
            $('#publish_date').val(date.toEnglishDigit());
        },
        onSet: function (unixDate) {
            var date = $('#publish_date').val();
            $('#publish_date').val(date.toEnglishDigit());
        }
    });

    var date = $('#publish_date_picker').val();

    if (date) {
        publishDatePicker.setDate(parseInt(date + '000'));
    }
});
