$('#discount-edit-form').submit(function (e) {
    e.preventDefault();

    if ($(this).valid() && !$(this).data('disabled')) {
        var formData = new FormData(this);
        var form = $(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                if (data == 'success') {
                    form.data('disabled', true);
                    window.location.href = form.data('redirect');
                }
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
    }
});

var method = $('#discount-method').val()
switch (method) {
    case 'code': {
        $("#discount-type").attr("readonly", false)
        $('.direct-hide').show();
        break;
    }
    case 'direct': {
        $('.direct-hide').hide();

        $("#discount-type").attr("readonly", true).val("percent")
        $("#discount-products-include").val("category")

        $('.percent').show();
        $('#categories-include').show();
        break;
    }
}
