jQuery('#change-username-form').validate({
    rules: {
        'username': {
            required: true,
        },

    },
});

$(document).ready(function() {

    $('#change-username-form').submit(function(e) {
        e.preventDefault();

        if ($(this).valid()) {

            var formData = new FormData(this);
            var form = $(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(data) {
                    window.location.href = form.data('redirect');
                },

                beforeSend: function(xhr) {
                    block('.form-ui');
                    xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
                },
                complete: function() {
                    unblock('.form-ui');
                },

                cache: false,
                contentType: false,
                processData: false
            });
        }

    });

});