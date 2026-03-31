$(document).ready(function() {

    $('#socials-form').submit(function(e) {
        e.preventDefault();

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
    });
});