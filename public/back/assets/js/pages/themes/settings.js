CKEDITOR.replaceClass = 'editor-textarea';
var elements = CKEDITOR.document.find('.inline-editor-textarea'),
    i = 0,
    element;

while ((element = elements.getItem(i++))) {
    CKEDITOR.inline(element, {
        height: 3000
    });
}

$(document).ready(function () {
    $('#theme-settings-form').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        for (var instanceName in CKEDITOR.instances) {
            formData.append(
                CKEDITOR.instances[instanceName].name,
                CKEDITOR.instances[instanceName].getData()
            );
        }
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                if (data == 'success') {
                    Swal.fire({
                        type: 'success',
                        title: 'تغییرات با موفقیت ذخیره شد',
                        confirmButtonClass: 'btn btn-primary',
                        confirmButtonText: 'باشه',
                        buttonsStyling: false
                    });
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
            },

            cache: false,
            contentType: false,
            processData: false
        });
    });
});
