$(document).on('click', '.btn-delete', function() {
    $('#post-delete-form').attr('action', BASE_URL + '/posts/' + $(this).data('post'));
    $('#post-delete-form').data('id', $(this).data('id'));
});

$('#post-delete-form').submit(function(e) {
    e.preventDefault();

    $('#delete-modal').modal('hide');

    var form = this;

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function(data) {
            //get current url
            var url = window.location.href;

            //remove post tr
            $('#post-' + $(form).data('id') + '-tr').remove();

            toastr.success('پست با موفقیت حذف شد.');

            //refresh posts list
            $(".app-content").load(url + " .app-content > *");
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