// validate form with jquery validation plugin
jQuery('#ticket-create-form').validate({
    rules: {
        'subject': {
            required: true,
        },
        'user_id': {
            required: true,
        },
        'message': {
            required: true,
        },

    },
});

$('#user_id').select2({
    rtl: true,
    width: '100%',
    placeholder: "انتخاب کنید",
});

$('#ticket-create-form').submit(function(e) {
    e.preventDefault();

    if ($(this).valid() && !$(this).data('disabled')) {

        if (filesDropzone.getUploadingFiles().length) {
            toastr.error('لطفا تا اتمام آپلود تصاویر منتظر بمانید', 'خطا', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
            return;
        }

        var upload_files = [];
        filesDropzone.files.forEach(function(item) {
            if (item.status == 'success') {
                upload_files.push(item.upload.filename);
            }
        });

        var formData = new FormData(this);
        formData.append('upload_files', upload_files)
        var form = $(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(data) {
                $('#ticket-create-form').data('disabled', true);
                window.location.href = form.data('redirect');
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