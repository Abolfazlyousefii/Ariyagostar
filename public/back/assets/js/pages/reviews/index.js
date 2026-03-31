$(document).on('click', '.btn-delete', function () {
    $('#review-delete-form').attr('action', $(this).data('action'));
    $('#review-delete-form').data('id', $(this).data('review'));
});

$('#review-delete-form').submit(function (e) {
    e.preventDefault();

    $('#delete-modal').modal('hide');

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function (data) {
            //remove review tr
            $(
                '#review-' + $('#review-delete-form').data('id') + '-tr'
            ).remove();

            toastr.success('نظر با موفقیت حذف شد.');

            reloadDiv('.list-reviews');
        },
        beforeSend: function (xhr) {
            block('#main-card');
            xhr.setRequestHeader(
                'X-CSRF-TOKEN',
                $('meta[name="csrf-token"]').attr('content')
            );
        },
        complete: function () {
            unblock('#main-card');
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$(document).on('click', '.show-review', function () {
    $.ajax({
        url: $(this).data('action'),
        type: 'GET',
        success: function (data) {
            $('#review-detail').empty();
            $('#review-detail').append(data);

            $('#show-modal').modal('show');
        },
        beforeSend: function (xhr) {
            block('#main-card');
        },
        complete: function () {
            unblock('#main-card');
        }
    });
});

$('#filter-reviews-form select').change(function () {
    $('#filter-reviews-form').submit();
});

$(document).on('submit', '#review-edit-form', function (e) {
    e.preventDefault();

    var form = $(this);
    var formData = new FormData(this);

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,

        success: function (data) {
            reloadDiv('.list-reviews');

            $('#show-modal').modal('hide');

            toastr.success('تغییرات با موفقیت انجام شد');
        },
        beforeSend: function (xhr) {
            block('.review-show-modal');
            xhr.setRequestHeader(
                'X-CSRF-TOKEN',
                $('meta[name="csrf-token"]').attr('content')
            );
        },
        complete: function () {
            unblock('.review-show-modal');
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$(document).on('click', '#edit-review-btn', function () {
    $('#edit-review-body').show();
    $('#review-body').hide();

    autosize(document.querySelectorAll('textarea'));
});

$(document).on('click', '#review-form-submit-btn', function () {
    $('#review-edit-form').trigger('submit');
});

$(document).on('click', '.remove-review-pint', function () {
    $(this).closest('.row').remove();
});
