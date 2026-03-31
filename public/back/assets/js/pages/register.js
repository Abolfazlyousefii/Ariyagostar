$(document).ready(function() {

    jQuery('#register-form').validate({
        rules: {
            'first_name': {
                required: true,
            },
            'last_name': {
                required: true,
            },
            'username': {
                required: true,
                maxlength: 191,
            },
            'admin_route_prefix': {
                required: true,
            },
            'password': {
                minlength: 6,
            },
            'password_confirmation': {
                equalTo: "#password"
            },
        },
    });

    $('#register-form').submit(function(e) {
        e.preventDefault();

        if ($(this).valid()) {
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(data) {
                    window.location.href = FRONT_URL + '/admin/' + data.admin_prefix;
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

});