$(document).on('click', '.btn-delete', function() {
    $('#theme-delete-form').attr('action', BASE_URL + '/themes/' + $(this).data('name'));
});

$('#theme-delete-form').submit(function(e) {
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

            toastr.success('قالب با موفقیت حذف شد.');

            //refresh themes list
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

$(document).on('click', '.set-as-theme', function(e) {

    $.ajax({
        url: $(this).data('action'),
        type: 'PUT',
        data: {},
        success: function(data) {
            //get current url
            var url = window.location.href;

            toastr.success('قالب با موفقیت انتخاب شد.');

            //refresh themes list
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