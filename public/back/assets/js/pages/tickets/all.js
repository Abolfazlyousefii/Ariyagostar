var dropzoneId = "ticket-file-dropzone";

Dropzone.autoDiscover = false;

/* config dropzone uploader for uploading images */
var filesDropzone = new Dropzone("div#" + dropzoneId, {
    url: $('#' + dropzoneId).data('url'),
    addRemoveLinks: true,
    acceptedFiles: '.png,.jpg,.jpeg,.zip',

    dictInvalidFileType: 'آپلود فایل با این فرمت ممکن نیست',
    dictRemoveFile: 'حذف',
    dictCancelUpload: 'لغو آپلود',
    dictResponseError: 'خطایی در بارگذاری فایل رخ داده است',

    init: function() {
        this.on("success", function(file, response) {
            file.upload.filename = response;
            console.log(response)
        });

    },

    removedfile: function(file) {

        var name = file.upload.filename;

        if (file.accepted) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'DELETE',
                url: $('#' + dropzoneId).data('remove-url'),
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