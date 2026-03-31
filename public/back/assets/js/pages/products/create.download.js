CKEDITOR.replace('download-description');

Dropzone.autoDiscover = false;

/* config dropzone uploader for uploading images */
var downloadDropzone = new Dropzone("div#download-product-images", {
    url: BASE_URL + "/products/image-store",
    addRemoveLinks: true,
    acceptedFiles: '.png,.jpg,.jpeg',

    dictInvalidFileType: 'آپلود فایل با این فرمت ممکن نیست',
    dictRemoveFile: 'حذف',
    dictCancelUpload: 'لغو آپلود',
    dictResponseError: 'خطایی در بارگذاری فایل رخ داده است',

    init: function() {
        this.on("success", function(file, response) {
            file.upload.filename = response.imagename;
        });

    },

    removedfile: function(file) {

        var name = file.upload.filename;

        if (file.accepted) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: BASE_URL + '/products/image-delete',
                data: { filename: name },
                success: function(data) {
                    // console.log("File has been successfully removed!!");
                },
                error: function(e) {
                    // console.log(e);
                }
            });
        }

        var fileRef;
        return (fileRef = file.previewElement) != null ? fileRef.parentNode.removeChild(file.previewElement) : void 0;
    },

    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    }
});

$('#download-product-create-form').submit(function(e) {
    e.preventDefault();

    if ($(this).valid() && !$(this).data('disabled')) {

        if (downloadDropzone.getUploadingFiles().length) {
            toastr.error('لطفا تا اتمام آپلود تصاویر منتظر بمانید', 'خطا', { positionClass: 'toast-bottom-left', containerId: 'toast-bottom-left' });
            return;
        }

        var images = [];
        downloadDropzone.files.forEach(function(item) {
            if (item.status == 'success') {
                images.push(item.upload.filename);
            }
        });

        var formData = new FormData(this);
        formData.append('description', CKEDITOR.instances['download-description'].getData())
        formData.append('images', images)

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(data) {
                $('#download-product-create-form').data('disabled', true);
                window.location.href = BASE_URL + "/products";
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
