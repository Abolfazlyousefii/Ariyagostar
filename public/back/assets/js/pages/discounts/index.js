$(document).on('click', '.btn-delete', function() {
    $('#discount-delete-form').attr('action', $(this).data('action'));
    $('#discount-delete-form').data('id', $(this).data('discount'));
});

$('#discount-delete-form').submit(function(e) {
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

            //remove discount tr
            $('#discount-' + $('#discount-delete-form').data('id') + '-tr').remove();

            toastr.success('کد تخفیف با موفقیت حذف شد.');

            //refresh discounts list
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