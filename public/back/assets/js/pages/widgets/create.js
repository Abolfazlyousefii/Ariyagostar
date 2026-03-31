$('#widget-key').on('change', function() {
    $('#template .row').empty();
    $('#widget-image').hide();

    let option = $(this).find(':selected');

    if (!option.val()) {
        return;
    }

    $('#widget-image').attr('src', option.data('image')).show();

    $.ajax({
        url: option.data('action'),
        type: 'GET',
        data: {
            option: option.val(),
        },
        success: function(data) {
            $('#template .row').append(data);
        },
        beforeSend: function(xhr) {
            block('#widget-create-form');
        },
        complete: function() {
            unblock('#widget-create-form');
        },
    });
});

jQuery('#widget-create-form').validate();

$('#widget-create-form').submit(function(e) {
    e.preventDefault();
    var form = $(this);

    if ($(this).valid() && !$(this).data('disabled')) {
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(data) {
                if (data == 'success') {
                    form.data('disabled', true);
                    window.location.href = form.data('redirect');
                }
            },
            beforeSend: function(xhr) {
                block('#main-card');
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            complete: function() {
                unblock('#main-card');
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    }
});