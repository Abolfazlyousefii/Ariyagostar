$(document).on('click', '.btn-delete', function () {
    $('#brand-delete-form').attr('action', $(this).data('action'));
    $('#brand-delete-form').data('id', $(this).data('id'));
});

$('#brand-delete-form').submit(function (e) {
    e.preventDefault();

    $('#delete-modal').modal('hide');

    var form = this;
    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function (data) {
            //get current url
            var url = window.location.href;

            //remove brand tr
            $('#brand-' + $(form).data('id') + '-tr').remove();

            toastr.success('برند با موفقیت حذف شد.');

            //refresh brands list
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
