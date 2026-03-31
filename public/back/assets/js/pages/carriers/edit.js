jQuery('#carrier-edit-form').validate({
    rules: {
        title: {
            required: true
        }
    }
});

$('#carrier-edit-form').on('submit', function (e) {
    e.preventDefault();
    var form = $(this);

    if ($(this).valid() && !$(this).data('disabled')) {
        var formData = new FormData(this);
        var included_cities = comboProvinces.getSelectedIds();

        if (included_cities) {
            included_cities = included_cities.filter(function (item) {
                return !isNaN(item);
            });

            for (var i = 0; i < included_cities.length; i++) {
                formData.append('included_cities[]', included_cities[i]);
            }
        }

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                if (data == 'success') {
                    $('#carrier-edit-form').data('disabled', true);
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
