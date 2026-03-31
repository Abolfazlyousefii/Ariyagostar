$('#theme-create-form').submit(function(e) {
    e.preventDefault();

    if ($(this).valid() && !$(this).data('disabled')) {
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(data) {
                $('#theme-create-form').data('disabled', true);
                window.location.href = BASE_URL + "/themes";
            },
            beforeSend: function(xhr) {
                block('#main-card');
                xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            },
            complete: function() {
                unblock('#main-card');
                $('#form-progress').hide();
                $('#form-progress').find('.progress-bar').css('width', '0%');
            },
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                //Upload progress
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;

                        $('#form-progress').show();
                        $('#form-progress').find('.progress-bar').css('width', percentComplete * 100 + '%');
                        $('#form-progress').find('.progress-bar').text(Math.round(percentComplete * 100) + '%');
                    }
                }, false);

                return xhr;
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

});