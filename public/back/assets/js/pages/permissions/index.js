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

$('#permissions-form').submit(function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function(data) {
            Swal.fire({
                type: 'success',
                title: 'تغییرات با موفقیت ذخیره شد',
                confirmButtonClass: 'btn btn-primary',
                confirmButtonText: 'باشه',
                buttonsStyling: false,
            });
        },
        beforeSend: function(xhr) {
            block('#main-card');
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        complete: function() {
            unblock('#main-card');
        },
        cache: false,
        contentType: false,
        processData: false
    });

});