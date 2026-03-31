$(document).on('click', '.btn-delete', function () {
    $('#page-delete-form').attr('action', BASE_URL + '/pages/' + $(this).data('page'));
    $('#page-delete-form').data('id', $(this).data('id'));
});

$('#page-delete-form').submit(function (e) {
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

            //remove page tr
            $('#page-' + $(form).data('id') + '-tr').remove();

            toastr.success('صفحه با موفقیت حذف شد.');

            //refresh pages list
            $(".app-content").load(url + " .app-content > *");
        },
        beforeSend: function (xhr) {
            block('#main-card');
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
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
    let text = $(this).closest('td').find('.page_link').val();
    copyToClipboard(text);
    toastr.success('لینک با موفقیت کپی شد');
});