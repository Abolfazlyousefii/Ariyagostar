$(document).on('click', '.btn-delete', function() {
    $('#stock_notify-delete-form').attr('action', BASE_URL + '/stock-notifies/' + $(this).data('stock_notify'));
    $('#stock_notify-delete-form').data('id', $(this).data('stock_notify'));
});

$('#stock_notify-delete-form').submit(function(e) {
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

            //remove stock_notify tr
            $('#stock_notify-' + $('#stock_notify-delete-form').data('id') + '-tr').remove();

            toastr.success('با موفقیت حذف شد.');

            //refresh stocknotifies list
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


$(document).on('click', '.show-stock_notify', function() {
    $.ajax({
        url: BASE_URL + '/stock-notifies/' + $(this).data('stock_notify'),
        type: 'GET',
        success: function(data) {
            $('#stock_notify-detail').empty();
            $('#stock_notify-detail').append(data);
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