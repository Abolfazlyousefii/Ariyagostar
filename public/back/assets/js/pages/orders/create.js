let autoCompleteUrl = $('#order-create-form').data('auto-complete-url');

$('#order-create-form input[name="username"]')
    .autocomplete({
        delay: 1000,
        minLength: 3,
        source: function (term, response) {
            $.ajax({
                url: `${autoCompleteUrl}?input=username`,
                type: 'GET',
                data: term,
                success: function (data) {
                    response(data);
                },
                error: function (data) {
                    //
                }
            });
        },
        select: function (event, ui) {
            setTimeout(function () {
                $(event.target).val(ui.item.username);
                $('#order-create-form input[name="first_name"]').val(
                    ui.item.first_name
                );
                $('#order-create-form input[name="last_name"]').val(
                    ui.item.last_name
                );
                $('#order-create-form select[name="city_id"]').data(
                    'id',
                    ui.item.address?.city_id
                );
                $('#order-create-form select[name="province_id"]')
                    .val(ui.item.address?.province_id)
                    .trigger('change');

                $('#order-create-form input[name="postal_code"]').val(
                    ui.item.address?.postal_code
                );
                $('#order-create-form textarea[name="address"]').val(
                    ui.item.address?.address
                );
            }, 100);
        }
    })
    .autocomplete('instance')._renderItem = function (ul, item) {
    return $('<li>')
        .attr('data-value', item.username)
        .append(
            `<li data-value="${item.username}">
                ${item.username}
                <small class="text-muted">
                    <p class="m-0">(${item.first_name} ${item.last_name})</p>
                </small>
            </li>`
        )
        .appendTo(ul);
};

let productsCount = 0;

$('#add-product-to-order')
    .autocomplete({
        delay: 1000,
        minLength: 3,
        source: function (term, response) {
            $.ajax({
                url: $('#add-product-to-order').data('action'),
                type: 'GET',
                data: term,
                success: function (data) {
                    response(data.data);
                },
                error: function (data) {
                    //
                }
            });
        },
        select: function (event, ui) {
            let template = ejs.render($('#product-template').html(), {
                product: ui.item
            });

            $('#order-products-list').append(template);
            productsCount++;
        }
    })
    .autocomplete('instance')._renderItem = function (ul, item) {
    return $('<li>')
        .attr('data-value', item.title)
        .append(
            `<li data-value="${item.title}" class="d-flex">
                <img src="${item.image}"
                    alt="${item.title}" style="width: 50px">
                <div class="ml-2">
                    ${item.title}
                    <small class="text-muted">
                        <p class="m-0">${number_format(item.price)} تومان</p>
                    </small>
                </div>
            </li>`
        )
        .appendTo(ul);
};

$(document).on(
    'click',
    '.order-single-product .delete-product-btn',
    function () {
        $(this).closest('.order-single-product').remove();
    }
);
$(document).on('change', '.order-single-product .price-select', function () {
    console.log($(this).val());
    let price = $(this).find('option:selected').data('price');

    $(this)
        .closest('.order-single-product')
        .find('.selected-price')
        .val(price.id);
    $(this)
        .closest('.order-single-product')
        .find('.product-quantity')
        .attr('max', price.cart_max);

    $(this)
        .closest('.order-single-product')
        .find('.sale-price')
        .text(number_format(price.sale_price));

    $(this)
        .closest('.order-single-product')
        .find('.regular-price')
        .text(number_format(price.regular_price));

    if (price.discount) {
        $(this)
            .closest('.order-single-product')
            .find('.regular-price-container')
            .removeClass('d-none');
    } else {
        $(this)
            .closest('.order-single-product')
            .find('.regular-price-container')
            .addClass('d-none');
    }
});

$('#order-create-form').submit(function (e) {
    e.preventDefault();

    if (!$(this).data('disabled')) {
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                $('#order-create-form').data('disabled', true);
                window.location.href = $('#order-create-form').data('redirect');
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

$('#province').trigger('change');
