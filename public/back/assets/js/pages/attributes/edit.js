// validate form with jquery validation plugin
jQuery('#attribute-edit-form').validate({
    rules: {
        'name': {
            required: true,
        },
        'attribute_group_id': {
            required: true,
        },
    },
});

$('#attribute-edit-form').submit(function(e) {
    e.preventDefault();

    if ($(this).valid() && !$(this).data('disabled')) {
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(data) {
                $('#attribute-edit-form').data('disabled', true);
                window.location.href = BASE_URL + "/attributeGroups";
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
    }
});