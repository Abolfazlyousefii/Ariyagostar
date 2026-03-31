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

jQuery('#post-create-form').validate({
    rules: {
        title: {
            required: true
        }
    }
});

$('#post-create-form').submit(function (e) {
    e.preventDefault();

    var form = $(this);

    if (form.valid() && !form.data('disabled')) {
        var date = $('#publish_date').val();
        $('#publish_date').val(date.toEnglishDigit());

        var formData = new FormData(this);
        formData.append('content', CKEDITOR.instances['content'].getData());

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                if (data == 'success') {
                    $('#post-create-form').data('disabled', true);
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

$('#publish_date_picker').pDatepicker({
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
    altField: '#publish_date',
    altFormat: 'YYYY-MM-DD HH:mm:ss',

    onSelect: function (unixDate) {
        var date = $('#publish_date').val();
        $('#publish_date').val(date.toEnglishDigit());
    }
});
