Dropzone.autoDiscover = false;

/* config dropzone uploader for uploading images */
var imageDropzone = new Dropzone('div#product-images', {
    url: BASE_URL + '/products/image-store',
    addRemoveLinks: true,
    acceptedFiles: 'image/*',

    previewTemplate: `
        <div class="dz-preview dz-file-preview">
            <div class="dz-details">
                <div class="dz-filename"><span data-dz-name></span></div>
                <div class="dz-size" data-dz-size></div> <img data-dz-thumbnail />
            </div>
            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
            <div class="dz-success-mark"><span>✔</span></div>
            <div class="dz-error-mark"><span>✘</span></div>
            <div class="dz-error-message"><span data-dz-errormessage></span></div>
            <select class="form-control d-none color-select"></select>
        </div>
      `,

    dictInvalidFileType: 'آپلود فایل با این فرمت ممکن نیست',
    dictRemoveFile: 'حذف',
    dictCancelUpload: 'لغو آپلود',
    dictResponseError: 'خطایی در بارگذاری فایل رخ داده است',

    init: function () {
        this.on('success', function (file, response) {
            if (file.prevFile) {
                $(file.previewElement).attr('data-name', file.upload.filename);
                $(file.previewElement).attr('id', file.upload.filename);
                $(file.previewElement)
                    .find('select.color-select')
                    .attr('data-image', file.upload.filename)
                    .attr('data-color-id', file.color_id);
            } else {
                file.upload.filename = response.imagename;

                $(file.previewElement).attr('data-name', response.imagename);
                $(file.previewElement).attr('id', response.imagename);
                $(file.previewElement)
                    .find('select.color-select')
                    .attr('data-image', response.imagename);
            }

            setColorsImage();
        });
    },

    removedfile: function (file) {
        var name = file.upload.filename;

        if (file.accepted) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: BASE_URL + '/products/image-delete',
                data: {filename: name, product: product},
                success: function (data) {
                    // console.log("File has been successfully removed!!");
                },
                error: function (e) {
                    // console.log(e);
                }
            });
        }

        var fileRef;
        return (fileRef = file.previewElement) != null
            ? fileRef.parentNode.removeChild(file.previewElement)
            : void 0;
    },

    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/* load saved image gallery */
mockImages.forEach(function (mockFile) {
    imageDropzone.emit('addedfile', mockFile);
    imageDropzone.emit('thumbnail', mockFile, mockFile.image);
    imageDropzone.emit('complete', mockFile);
    imageDropzone.emit('success', mockFile);
    imageDropzone.files.push(mockFile);
});

$('#product-edit-form').submit(function (e) {
    e.preventDefault();

    if ($(this).valid() && !$(this).data('disabled')) {
        var form = this;

        var date = $('#publish_date').val();
        $('#publish_date').val(date.toEnglishDigit());

        if (imageDropzone.getUploadingFiles().length) {
            toastr.error('لطفا تا اتمام آپلود تصاویر منتظر بمانید', 'خطا', {
                positionClass: 'toast-bottom-left',
                containerId: 'toast-bottom-left'
            });
            return;
        }

        var images = $('.dropzone-area').sortable('toArray');

        var formData = new FormData(this);
        formData.append(
            'description',
            CKEDITOR.instances['description'].getData()
        );
        formData.append('images', images);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                if (data == 'success') {
                    $(form).data('disabled', true);
                    window.location.href = $(form).data('redirect');
                }
            },
            beforeSend: function (xhr) {
                block('#main-card');
                xhr.setRequestHeader(
                    'X-CSRF-TOKEN',
                    $('meta[name="csrf-token"]').attr('content')
                );
            },
            complete: function () {
                unblock('#main-card');
                $('#form-progress').hide();
                $('#form-progress').find('.progress-bar').css('width', '0%');
            },
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                //Upload progress
                xhr.upload.addEventListener(
                    'progress',
                    function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;

                            $('#form-progress').show();
                            $('#form-progress')
                                .find('.progress-bar')
                                .css('width', percentComplete * 100 + '%');
                            $('#form-progress')
                                .find('.progress-bar')
                                .text(Math.round(percentComplete * 100) + '%');
                        }
                    },
                    false
                );

                return xhr;
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
});

var publishDatePicker;

jQuery(function () {
    publishDatePicker = $('#publish_date_picker').pDatepicker({
        timePicker: {
            enabled: true,
            meridian: {
                enabled: false
            },
            second: {
                enabled: false
            }
        },
        toolbox: {
            // enabled: true,
            calendarSwitch: {
                enabled: false
            }
        },
        initialValue: false,
        initialValueType: 'persian',
        altField: '#publish_date',
        altFormat: 'YYYY-MM-DD HH:mm:ss',

        onSelect: function (unixDate) {
            var date = $('#publish_date').val();
            $('#publish_date').val(date.toEnglishDigit());
        },
        onSet: function (unixDate) {
            var date = $('#publish_date').val();
            $('#publish_date').val(date.toEnglishDigit());
        }
    });

    var date = $('#publish_date_picker').val();

    if (date) {
        publishDatePicker.setDate(parseInt(date + '000'));
    }
});
