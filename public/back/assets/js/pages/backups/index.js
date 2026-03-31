$(document).on('click', '.btn-delete', function() {
    $('#backup-delete-form').attr('action', BASE_URL + '/backups/' + $(this).data('backup'));
    $('#backup-delete-form').data('id', $(this).data('id'));
});

$('#backup-delete-form').submit(function(e) {
    e.preventDefault();

    $('#delete-modal').modal('hide');

    var form = this;

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'post',
        data: formData,
        success: function(data) {
            //get current url
            var url = window.location.href;

            //remove backup tr
            $('#backup-' + $(form).data('id') + '-tr').remove();

            toastr.success('بکاپ با موفقیت حذف شد.');

            //refresh backups list
            $(".app-content").load(url + " .app-content > *");
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

$(document).on('click', '#create-backup-btn', function() {

    Swal.fire({
        type: 'success',
        title: 'با موفقیت آغاز شد',
        text: 'فرآیند بکاپ گیری با موفقیت آغاز شد، تا پایان بکاپ گیری ممکن است چند دقیقه طول بکشد، لطفا صبور باشید. بعد از چند دقیقه لیست بکاپ ها را دوباره چک کنید',
        confirmButtonClass: 'btn btn-primary',
        confirmButtonText: 'باشه',
        buttonsStyling: false,
    });

    $.ajax({
        url: $(this).data('action'),
        type: 'post',
        data: {},
        success: function(data) {

        },
        beforeSend: function(xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        cache: false,
        contentType: false,
        processData: false
    });
});