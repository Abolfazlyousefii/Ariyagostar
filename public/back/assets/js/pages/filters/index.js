$(document).on('click', '.btn-delete', function() {
    $('#filter-delete-form').attr('action', BASE_URL + '/filters/' + $(this).data('filter'));
    $('#filter-delete-form').data('id', $(this).data('filter'));
});

$('#filter-delete-form').submit(function(e) {
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

            //remove filter tr
            $('#filter-' + $('#filter-delete-form').data('id') + '-tr').remove();

            toastr.success('فیلتر با موفقیت حذف شد.');

            //refresh filters list
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