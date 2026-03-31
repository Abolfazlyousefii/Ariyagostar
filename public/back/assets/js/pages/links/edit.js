// validate form with jquery validation plugin
jQuery('#link-edit-form').validate({
    rules: {
        'title': {
            required: true,
        },
        'link': {
            required: true,
        },
        'link_group_id': {
            required: true,
        },
    },
});

$(".link-link").autocomplete({
    source: pages
});

$('#link-edit-form').submit(function(e) {
    e.preventDefault();

    if ($(this).valid() && !$(this).data('disabled')) {
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(data) {
                $('#link-edit-form').data('disabled', true);
                window.location.href = BASE_URL + "/links";
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