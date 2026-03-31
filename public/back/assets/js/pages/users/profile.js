$(document).ready(function() {
    /*=========+===================
      Profile Tab Js Codes
    ===============================*/

    // validate form with jquery validation plugin
    jQuery('#profile-form').validate({
        errorClass: 'invalid-feedback animated fadeInDown',
        errorPlacement: function(error, e) {
            jQuery(e).parents('.form-group > div').append(error);
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
            'password': {
                minlength: 6,
            },
            'password_confirmation': {
                equalTo: "#password"
            },
        },
        messages: {
            'first_name': {
                required: 'لطفا نام خودتان را وارد کنید',
            },
            'last_name': {
                required: 'لطفا نام خانوادگی خودتان را وارد کنید',
            },
            'username': {
                required: 'لطفا نام کاربری را وارد کنید',
            },
            'password': {
                minlength: 'گذرواژه باید حداقل 6 کاراکتر باشد',
            },
            'password_confirmation': {
                equalTo: 'تکرار گذرواژه با گذرواژه برابر نیست',
            },

        }
    });

    $('#edit-image-btn').click(function() {
        $('#profile-image').trigger('click');
    });

    $('#profile-image').change(function() {
        if (this.files && this.files[0]) {

            var FR = new FileReader();

            FR.addEventListener("load", function(e) {
                document.getElementById("profile-pic").src = e.target.result;
            });

            FR.readAsDataURL(this.files[0]);
        }
    });

    $('#profile-form').submit(function(e) {
        e.preventDefault();

        if ($(this).valid()) {
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(data) {
                    Swal.fire({
                        type: 'success',
                        title: 'تغییرات با موفقیت ذخیره شد',
                        confirmButtonClass: 'btn btn-primary',
                        confirmButtonText: 'باشه',
                        buttonsStyling: false,
                    })
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

    if (WEB_PUSH_NOTIFICATION) {
        subscribe();
    } else {
        unsubscribe();
    }

    $('#subscribe-to-webpush').on('change', function() {
        var checked = $(this).is(':checked');

        if (checked) {
            subscribe();
        } else {
            unsubscribe();
        }
    });
});