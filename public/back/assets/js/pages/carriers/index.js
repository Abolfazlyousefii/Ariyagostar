$(document).on('click', '.btn-delete', function () {
    $('#carrier-delete-form').attr('action', $(this).data('action'));
});

$('#carrier-delete-form').submit(function (e) {
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

                toastr.success('برند با موفقیت حذف شد.');

                //refresh carriers list
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

$('.carrier-cities-show').on('click', function (e) {
    e.preventDefault();

    let link = $(this);

    $.ajax({
        type: 'GET',
        url: link.attr('href'),
        success: function (data) {
            $('#carrier-cities-list').empty();
            $('#carrier-cities-list').append(data);
            $('#show-modal').modal('show');
        },
        beforeSend: function () {
            block(link);
        },
        complete: function () {
            unblock(link);
        }
    });
});
