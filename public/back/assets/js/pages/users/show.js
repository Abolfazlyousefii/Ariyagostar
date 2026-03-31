$(document).on('click', '.btn-user-delete', function() {
    $('#user-delete-form').attr('action', BASE_URL + '/users/' + $(this).data('user'));
    $('#user-delete-form').data('id', $(this).data('user'));
});

$('#user-delete-form').submit(function(e) {
    e.preventDefault();

    $('#user-delete-modal').modal('hide');

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function(data) {
            window.location.href = BASE_URL + "/users";
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