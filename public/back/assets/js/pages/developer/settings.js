$(document).on('submit', '#downApplication-form', function (e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function (data) {
            Swal.fire({
                type: 'success',
                title: 'با موفقیت انجام شد',
                confirmButtonClass: 'btn btn-primary',
                confirmButtonText: 'باشه',
                buttonsStyling: false,
            });

            $.ajax({
                url: FRONT_URL + "/" + data.secret,
                type: 'GET',
                complete: function () {
                    //get current url
                    var url = window.location.href;

                    //refresh pages list
                    $(".app-content").load(url + " .app-content > *");
                },
                error: function (e) {
                    console.log(e);
                }
            });
        },
        beforeSend: function (xhr) {
            block('#main-card');
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        complete: function () {
            unblock('#main-card');
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$(document).on('submit', '.developer-form', function (e) {
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function (data) {
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
        beforeSend: function (xhr) {
            block('#main-card');
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        complete: function () {
            unblock('#main-card');
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$(document).on('keyup', '#downApplication-secret-input', function () {
    var secret = $(this).val();

    $('#downApplication-secret').text('/' + secret);
});
