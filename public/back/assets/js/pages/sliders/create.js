// validate form with jquery validation plugin
jQuery('#slider-create-form').validate({
    errorClass: 'invalid-feedback animated fadeInDown',
    errorPlacement: function(error, e) {
        jQuery(e).parents('.form-group').append(error);
    },
    highlight: function(e) {
        jQuery(e).closest('.form-group').find('input').removeClass('is-invalid').addClass('is-invalid');
    },
    success: function(e) {
        jQuery(e).closest('.form-group').find('input').removeClass('is-invalid');
        jQuery(e).remove();
    },
    invalidHandler: function(form, validator) {

        if (!validator.numberOfInvalids())
            return;

        $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top - 150
        }, 200);

        $(validator.errorList[0].element).focus();

    },
    rules: {
        'image': {
            required: true,
        },
        'group': {
            required: true,
        },
    },
});

$(".slider-link").autocomplete({
    source: pages
});

$('#slider-create-form').submit(function(e) {
    e.preventDefault();

    if ($(this).valid() && !$(this).data('disabled')) {
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(data) {
                $('#slider-create-form').data('disabled', true);
                window.location.href = BASE_URL + "/sliders";
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