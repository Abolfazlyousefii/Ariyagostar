$('select[name="attribute_group_id"]').on('change', function() {
    var option = $(this).children("option:selected");
    var type = option.data('type');

    if (type == 'color') {
        $('#color-select-div').show();
    } else {
        $('#color-select-div').hide();
    }
});

$('select[name="attribute_group_id').trigger('change');