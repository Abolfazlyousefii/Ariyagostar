$(document).on('click', '.btn-delete', function () {
    $('#apikey-delete-form').attr('action', $(this).data('action'));
});

$('#apikey-delete-form').submit(function (e) {
    e.preventDefault();

    $('#delete-modal').modal('hide');

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function (data) {
            //get current url
            var url = window.location.href;

            toastr.success('کلید وب سرویس با موفقیت حذف شد.');

            //refresh apikeys list
            $('.app-content').load(url + ' .app-content > *');
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
});

$('.copy_btn').on('click', function () {
    let text = $(this).closest('td').find('.apikey_key').val();
    copyToClipboard(text);
    toastr.success('لینک با موفقیت کپی شد');
});
