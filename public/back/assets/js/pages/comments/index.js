$(document).on('click', '.btn-delete', function() {
    $('#comment-delete-form').attr('action', $(this).data('action'));
    $('#comment-delete-form').data('id', $(this).data('comment'));
});

$('#comment-delete-form').submit(function(e) {
    e.preventDefault();

    $('#delete-modal').modal('hide');

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function(data) {

            //remove comment tr
            $('#comment-' + $('#comment-delete-form').data('id') + '-tr').remove();

            toastr.success('دیدگاه با موفقیت حذف شد.');

            reloadDiv('.list-comments');
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


$(document).on('click', '.show-comment', function() {
    $.ajax({
        url: BASE_URL + '/comments/' + $(this).data('comment'),
        type: 'GET',
        success: function(data) {
            $('#comment-detail').empty();
            $('#comment-detail').append(data);

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

$('#filter-comments-form select').change(function() {
    $('#filter-comments-form').submit();
});

$(document).on('submit', '#comment-edit-form', function(e) {

    e.preventDefault();

    var form = $(this);
    var formData = new FormData(this);

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,

        success: function(data) {

            reloadDiv('.list-comments');

            $('#show-modal').modal('hide');

            toastr.success("تغییرات با موفقیت انجام شد");
        },
        beforeSend: function(xhr) {
            block('.comment-show-modal');
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        complete: function() {
            unblock('.comment-show-modal');
        },
        cache: false,
        contentType: false,
        processData: false
    });

});

$(document).on('click', '#edit-comment-btn', function() {
    $('#edit-comment-body').show();
    $('#comment-body').hide();

    autosize(document.querySelectorAll('textarea'));
});

$(document).on('click', '#comment-form-submit-btn', function() {
    $('#comment-edit-form').trigger('submit');
});
