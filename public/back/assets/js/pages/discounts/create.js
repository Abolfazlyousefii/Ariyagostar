$('#start_date_picker').pDatepicker({
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
    altField: '#start_date',
    altFormat: 'YYYY-MM-DD HH:mm:ss',

    onSelect: function (unixDate) {
        var date = $('#start_date').val();
        $('#start_date').val(date.toEnglishDigit());
    }
});

$('#start_date_picker').on('keydown', function (e) {
    e.preventDefault();
    $(this).val('');
    $('#start_date').val('');
});

$('#end_date_picker').pDatepicker({
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
    altField: '#end_date',
    altFormat: 'YYYY-MM-DD HH:mm:ss',

    onSelect: function (unixDate) {
        var date = $('#end_date').val();
        $('#end_date').val(date.toEnglishDigit());
    }
});

$('#end_date_picker').on('keydown', function (e) {
    e.preventDefault();
    $(this).val('');
    $('#end_date').val('');
});

$('#discount-create-form').submit(function (e) {
    e.preventDefault();

    if ($(this).valid() && !$(this).data('disabled')) {
        var formData = new FormData(this);
        var form = $(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                if (data == 'success') {
                    form.data('disabled', true);
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
