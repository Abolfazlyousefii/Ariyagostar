jQuery('#tariff-create-form').validate({
    rules: {
        max_weight: {
            required: true
        },
        shipping_cost: {
            required: true
        }
    }
});

$('#tariff-create-form').on('submit', function (e) {
    e.preventDefault();
    var form = $(this);

    if ($(this).valid() && !$(this).data('disabled')) {
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                if (data == 'success') {
                    $('#tariff-create-form').data('disabled', true);
                    window.location.href = form.data('redirect');
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
    }
});
