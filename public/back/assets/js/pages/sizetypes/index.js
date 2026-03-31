$(document).on('click', '.btn-delete', function () {
    $('#sizetype-delete-form').attr('action', $(this).data('action'));
    $('#sizetype-delete-form').data('id', $(this).data('sizetype'));
    console.log('ddddd');
});

$('#sizetype-delete-form').submit(function (e) {
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

            //remove sizetype tr
            $(
                '#sizetype-' + $('#sizetype-delete-form').data('id') + '-tr'
            ).remove();

            toastr.success('راهنمای سایز با موفقیت حذف شد.');

            //refresh sizetypes list
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
