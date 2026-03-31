$('#discount-products-include').on('change', function () {
    switch ($(this).val()) {
        case 'all': {
            $('#categories-include').hide();
            $('#products-include').hide();
            break;
        }
        case 'category': {
            $('#categories-include').show();
            $('#products-include').hide();
            break;
        }
        case 'product': {
            $('#categories-include').hide();
            $('#products-include').show();
            break;
        }
    }
});

$('#discount-method').on('change', function () {
    switch ($(this).val()) {
        case 'code': {
            $("#discount-type").attr("readonly", false)
            $('.direct-hide').show();

            $('input, select').prop("disabled", false)
            break;
        }
        case 'direct': {
            $('.direct-hide').hide();

            $("#discount-type").attr("readonly", true).val("percent")
            $("#discount-products-include").val("category")

            $('.percent').show();
            $('#categories-include').show();
            $('input, select').prop("disabled", false)
            break;
        }

        case 'carrier': {
            $('input, select').not('.carrier-method-required, input[type="hidden"]').prop('disabled', true);

            break;
        }
    }
});

if($('#discount-method').val() == "carrier"){
    $('input, select').not('.carrier-method-required, input[type="hidden"]').prop('disabled', true);
}

$('#discount-products-include').trigger('change');

$('#discount-type').on('change', function () {
    switch ($(this).val()) {
        case 'percent': {
            $('.amount').hide();
            $('.percent').show();
            break;
        }
        case 'amount': {
            $('.amount').show();
            $('.percent').hide();
            break;
        }
    }
});

$('#discount-type').trigger('change');

$('#discount-products-exclude').on('change', function () {
    switch ($(this).val()) {
        case 'none': {
            $('#categories-exclude').hide();
            $('#products-exclude').hide();
            break;
        }
        case 'category': {
            $('#categories-exclude').show();
            $('#products-exclude').hide();
            break;
        }
        case 'product': {
            $('#categories-exclude').hide();
            $('#products-exclude').show();
            break;
        }
    }
});

$('#discount-products-exclude').trigger('change');

$('#categories-include-select').select2ToTree({
    rtl: true,
    width: '100%'
});

$('#categories-exclude-select').select2ToTree({
    rtl: true,
    width: '100%'
});

$('#users-include, #products-include-select, #products-exclude-select').select2(
    {
        rtl: true,
        width: '100%'
    }
);

var startDatePicker = $('#start_date_picker').pDatepicker({
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
    },
    onSet: function (unixDate) {
        var date = $('#start_date').val();
        $('#start_date').val(date.toEnglishDigit());
    }
});

var start_date = $('#start_date_picker').val();

if (start_date) {
    startDatePicker.setDate(parseInt(start_date + '000'));
}

$('#start_date_picker').on('keydown', function (e) {
    e.preventDefault();
    $(this).val('');
    $('#start_date').val('');
});

var endDatePicker = $('#end_date_picker').pDatepicker({
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
    },
    onSet: function (unixDate) {
        var date = $('#end_date').val();
        $('#end_date').val(date.toEnglishDigit());
    }
});

var end_date = $('#end_date_picker').val();

if (end_date) {
    endDatePicker.setDate(parseInt(end_date + '000'));
}

$('#end_date_picker').on('keydown', function (e) {
    e.preventDefault();
    $(this).val('');
    $('#end_date').val('');
});

//--------------- generate random code
$('#generate-new-code').on('click', function () {
    var code = randomString(6);
    $('#main-card input[name="code"]').val(code);
});
