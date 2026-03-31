$(document).on('click', '.btn-delete', function() {
    $('#contact-delete-form').attr('action', BASE_URL + '/contacts/' + $(this).data('contact'));
    $('#contact-delete-form').data('id', $(this).data('contact'));
});

$('#contact-delete-form').submit(function(e) {
    e.preventDefault();

    $('#delete-modal').modal('hide');

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function(data) {
            //get current url
            var url = window.location.href;

            //remove contact tr
            $('#contact-' + $('#contact-delete-form').data('id') + '-tr').remove();

            toastr.success('پیام با موفقیت حذف شد.');

            //refresh contacts list
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


$(document).on('click', '.show-contact', function() {
    $.ajax({
        url: BASE_URL + '/contacts/' + $(this).data('contact'),
        type: 'GET',
        success: function(data) {
            $('#contact-detail').empty();
            $('#contact-detail').append(data);
            $('#show-modal').modal('show');

        },
        beforeSend: function(xhr) {
            block('#main-card');
        },
        complete: function() {
            unblock('#main-card');
        }
    });

});