$(document).on('click', '#update-application', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'آیا مطمئن هستید؟',
        text: "اگر در سورس کد تغییرات ایجاد کرده اید، با بروزرسانی نرم افزار تغییرات از بین می روند!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'بله بروزرسانی شود',
        cancelButtonText: 'خیر',
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-danger ml-1',
        buttonsStyling: false,
    }).then(function(result) {
        if (result.value) {
            Swal.fire({
                type: 'success',
                title: 'عملیات بروزرسانی با موفقیت شروع شد لطفا منتظر بمانید',
                confirmButtonClass: 'btn btn-primary',
                confirmButtonText: 'باشه',
                buttonsStyling: false,
            });

            startUpdate();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                title: 'لغو شد',
                text: 'عملیات بروزرسانی نرم افزار لغو شد.',
                confirmButtonText: 'باشه',
                type: 'error',
                confirmButtonClass: 'btn btn-success',
            });
        }
    });
});

$(document).on('click', '#updater-after', function(e) {
    e.preventDefault();

    $.ajax({
        url: $(this).data('action'),
        type: 'POST',
        data: {},
        success: function(data) {
            Swal.fire({
                type: 'success',
                title: 'با موفقیت انجام شد',
                confirmButtonClass: 'btn btn-primary',
                confirmButtonText: 'باشه',
                buttonsStyling: false,
            });

            //get current url
            var url = window.location.href;

            //refresh pages list
            $(".app-content").load(url + " .app-content > *");
        },
        beforeSend: function(xhr) {
            block('#main-card');
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

function startUpdate() {
    var percentComplete = 0;

    var updaterInterval = setInterval(function() {
        if (percentComplete >= 100) {
            percentComplete = 0;
        }

        $('#form-progress').show();
        $('#form-progress').find('.progress-bar').css('width', percentComplete + '%');
        percentComplete++;
    }, 300);

    $.ajax({
        url: $(this).data('action'),
        type: 'POST',
        data: {},
        success: function(data) {
            Swal.fire({
                type: 'success',
                title: 'با موفقیت انجام شد',
                confirmButtonClass: 'btn btn-primary',
                confirmButtonText: 'باشه',
                buttonsStyling: false,
            });

            //get current url
            var url = window.location.href;

            //refresh pages list
            $(".app-content").load(url + " .app-content > *");
        },
        beforeSend: function(xhr) {
            block('#main-card');
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        complete: function() {
            unblock('#main-card');

            clearInterval(updaterInterval);
            $('#form-progress').find('.progress-bar').css('width', '100%');

            setTimeout(function() {
                $('#form-progress').hide();
            }, 2000);

        },
        error: function() {
            var timerInterval;

            Swal.fire({
                title: 'خطایی رخ داده است',
                type: 'error',
                html: 'در حال رفرش برای بررسی نصب بروزرسانی <strong></strong>',
                timer: 5000,
                confirmButtonClass: 'btn btn-primary',
                confirmButtonText: '  ',
                buttonsStyling: false,
                onBeforeOpen: function() {
                    Swal.showLoading()
                    timerInterval = setInterval(function() {
                        Swal.getContent().querySelector('strong')
                            .textContent = Math.round((Swal.getTimerLeft() / 1000) + 1)
                    }, 100)
                },
                onClose: function() {
                    clearInterval(timerInterval)
                }
            }).then(function(result) {
                if (result.dismiss === Swal.DismissReason.timer) {
                    location.reload();
                }
            });
        },
        cache: false,
        contentType: false,
        processData: false
    });
}