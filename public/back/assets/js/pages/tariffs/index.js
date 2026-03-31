$(document).on('click', '.btn-delete', function () {
    $('#tariff-delete-form').attr('action', $(this).data('action'));
});

$('#tariff-delete-form').submit(function (e) {
    e.preventDefault();

    $('#delete-modal').modal('hide');

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function (data) {
            if (data == 'success') {
                //get current url
                var url = window.location.href;

                toastr.success('تعرفه با موفقیت حذف شد.');

                //refresh tariffs list
                $('.app-content').load(url + ' .app-content > *');
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
});
