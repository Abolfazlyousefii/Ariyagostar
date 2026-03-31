$('.parent-permission').change(function() {
    var permissionId = $(this).data('id');
    var checked = $(this).prop('checked');

    if (checked) {
        $(this).closest('.card').find('.collapse').collapse('show');
        $(this).closest('.card').find('[data-action="collapse"]').addClass('rotate');
    } else {
        $(this).closest('.card').find('.collapse').collapse('hide');
        $(this).closest('.card').find('[data-action="collapse"]').removeClass('rotate');
    }

    $('input[data-permission_id="' + permissionId + '"').prop('checked', checked);
});