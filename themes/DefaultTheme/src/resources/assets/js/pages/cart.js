$('.cart_quantity').on('click keyup keydown keypress focus', function (e) {
    e.preventDefault();
});

$('.counter-box .inc').on('click', function (e) {
    if (
        parseInt($(this).parent().find('.cart_quantity').val()) >=
        parseInt($(this).parent().find('.cart_quantity').attr('max'))
    ) {
        toastr.error(
            'شما بیشترین تعداد ممکن برای این محصول را انتخاب کرده اید.'
        );
        e.preventDefault();
    }

    this.parentNode.querySelector('input[type=number]').stepUp();
    $(this).parent().find('.cart_quantity').trigger('change');
});

$('.counter-box .dec').on('click', function (e) {
    if (
        parseInt($(this).parent().find('.cart_quantity').val()) <=
        parseInt($(this).parent().find('.cart_quantity').attr('min'))
    ) {
        $('#delete-form').attr('action', $(this).data('action'));
        jQuery('#delete-modal').modal('show');
    }

    this.parentNode.querySelector('input[type=number]').stepDown();
    $(this).parent().find('.cart_quantity').trigger('change');
});

$('.cart_quantity').on('change', function (e) {
    var removeClass = $(this).data('remove-class');
    var minusClass = $(this).data('minus-class');

    if ($(this).val() <= $(this).attr('min')) {
        $(this).parent().find('.dec i').removeClass(minusClass);
        $(this).parent().find('.dec i').addClass(removeClass);
    } else {
        $(this).parent().find('.dec i').removeClass(removeClass);
        $(this).parent().find('.dec i').addClass(minusClass);
    }
});

$('.cart_quantity').trigger('change');

$(document).on('click', '#update-cart, #checkout-link', function () {
    if (!$('#cart-update-form').length) {
        return;
    }

    var btn = this;

    var formData = new FormData(document.getElementById('cart-update-form'));

    $.ajax({
        url: $(btn).data('action'),
        type: 'POST',
        data: formData,
        success: function (data) {
            window.location.href = $(btn).data('redirect');
        },
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                'X-CSRF-TOKEN',
                $('meta[name="csrf-token"]').attr('content')
            );
            block(btn);
            $('#cart-errors').hide();
            $('#cart-errors').find('p').remove();
        },
        complete: function () {
            unblock(btn);
        },
        error: function (request, status, error) {
            var errors = request.responseJSON.errors;
            if (errors) {
                errors.forEach(function (error) {
                    $('#cart-errors').prepend('<p>' + error + '</p>');
                });

                $('#cart-errors').show();

                $('html, body').animate(
                    {
                        scrollTop: $('body').offset().top
                    },
                    500
                );
            } else {
                alert('خطایی رخ داده است.');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});
