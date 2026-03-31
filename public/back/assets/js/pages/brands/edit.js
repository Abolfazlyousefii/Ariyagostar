// validate form with jquery validation plugin
jQuery('#brand-edit-form').validate({
    rules: {
        name: {
            required: true
        },
        slug: {
            required: true
        }
    }
});

CKEDITOR.replace('description');

$('#brand-edit-form').submit(function (e) {
    e.preventDefault();

    if ($(this).valid() && !$(this).data('disabled')) {
        var formData = new FormData(this);

        formData.append(
            'description',
            CKEDITOR.instances['description'].getData()
        );

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                $('#brand-edit-form').data('disabled', true);
                window.location.href = BASE_URL + '/brands';
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
    }
});
