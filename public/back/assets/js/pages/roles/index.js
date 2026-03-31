$(document).on('click', '.btn-delete', function() {
    $('#role-delete-form').attr('action', BASE_URL + '/roles/' + $(this).data('role'));
    $('#role-delete-form').data('id', $(this).data('id'));
});

$('#role-delete-form').submit(function(e) {
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

            //remove role tr
            $('#role-' + $(form).data('id') + '-tr').remove();

            toastr.success('مقام با موفقیت حذف شد.');

            //refresh roles list
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