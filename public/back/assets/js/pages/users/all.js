$('#roles').select2({
    rtl: true,
    width: '100%',
});

$('#level').change(function() {

    if ($(this).val() == 'admin') {
        $('#roles-div').show();
    } else {
        $('#roles-div').hide();
    }
});

$('#level').trigger('change');