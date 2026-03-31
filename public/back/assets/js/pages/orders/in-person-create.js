let autoCompleteUrl = $('#order-create-form').data('auto-complete-url');

function autoCompleteAction(field) {
    if (!$(`#order-create-form input[name="${field}"]`).length) return;

    $(`#order-create-form input[name="${field}"]`)
        .autocomplete({
            delay: 1000,
            minLength: 3,
            source: function (term, response) {
                console.log(this);

                $.ajax({
                    url: `${autoCompleteUrl}?input=${field}`,
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
                    $('#order-create-form input[name="username"]').val(
                        ui.item.username
                    );
                    $('#order-create-form input[name="first_name"]').val(
                        ui.item.first_name
                    );
                    $('#order-create-form input[name="last_name"]').val(
                        ui.item.last_name
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
}

autoCompleteAction('username');
autoCompleteAction('first_name');
autoCompleteAction('last_name');

$('#add-product-to-order').bind('paste', function (e) {
    var pastedData = e.originalEvent.clipboardData.getData('text');

    paste = pastedData.replace('\\-', 'p-');
});

let uiData;
let lastID;

$('#add-product-to-order')
    .autocomplete({
        delay: 500,
        minLength: 1,
        source: function (term, response) {
            term.term = term.term.replace('\\-', 'p-');

            $.ajax({
                url: $('#add-product-to-order').data('action'),
                type: 'GET',
                data: term,
                success: function (data) {
                    let paste = $('#add-product-to-order')
                        .val()
                        .replace('\\-', 'p-');
                    if (
                        data.data.length == 1 &&
                        (paste.includes('p-') || paste.includes('P-'))
                    ) {
                        setTimeout(() => {
                            $('.product-autocomplete-list')
                                .first()
                                .trigger('click');
                        }, 100);
                    }

                    setTimeout(() => {
                        $('#order-create-form').validate();
                    }, 200);

                    response(data.data);
                },
                error: function (data) {
                    //
                }
            });
        },
        select: function (event, ui) {
            let value = $('#add-product-to-order').val().replace('\\-', 'p-');

            lastID = value.replace('p-', '');

            if (
                value.includes('p-') &&
                $(`.order-single-product[data-selected-price="${lastID}"]`)
                    .length > 0
            ) {
                $('#add-product-modal').modal('show');
            } else {
                uiData = ui;
                addProduct(ui);
            }
        }
    })
    .autocomplete('instance')._renderItem = function (ul, item) {
    return $('<li>')
        .attr('data-value', item.title)
        .append(
            `<li data-value="${
                item.title
            }" class="d-flex product-autocomplete-list">
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

$('#add-new-row').on('click', function () {
    addProduct(uiData);
});

$('#add-to-prev').on('click', function () {
    let el = $(`.order-single-product[data-selected-price="${lastID}"]`).find(
        '.product-quantity'
    );

    el.val(parseInt(el.val()) + 1).trigger('change');
});

function addProduct(ui) {
    let template = ejs.render($('#product-template').html(), {
        product: ui.item
    });

    $('#order-products-list').append(template);

    $('.order-single-product:last-child .price-select').trigger('change');

    productsCount++;
}

$(document).on(
    'click',
    '.order-single-product .delete-product-btn',
    function () {
        $(this).closest('.order-single-product').remove();
    }
);
$(document).on('change', '.order-single-product .price-select', function () {
    let price = $(this).find('option:selected').data('price');

    $(this)
        .closest('.order-single-product')
        .find('.selected-price')
        .val(price.id);

    $(this)
        .closest('.order-single-product')
        .find('.product-discount')
        .val(price.regular_price - price.sale_price);

    $(this)
        .closest('.order-single-product')
        .find('.product-price')
        .val(price.regular_price);

    $(this)
        .closest('.order-single-product')
        .find('.sale-price')
        .text(number_format(price.sale_price));

    $(this)
        .closest('.order-single-product')
        .find('.regular-price')
        .text(number_format(price.regular_price));

    let max = price.stock;

    let prev_price = $(this)
        .closest('.order-single-product')
        .find('.product-quantity')
        .data('prev-id');

    if (price.id == prev_price) {
        max += $(this)
            .closest('.order-single-product')
            .find('.product-quantity')
            .data('prev-quantity');
    }

    $(this)
        .closest('.order-single-product')
        .find('.product-quantity')
        .attr('max', max);

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

    $(this)
        .closest('.order-single-product')
        .attr('data-selected-price', price.id);
    $('.product-quantity').trigger('change');
    $('.amount-input').trigger('keyup');
});

$(document).on('change', '.product-quantity', function () {
    $(this).closest('.order-single-product').find('.stock-alert').remove();

    let price = $(this)
        .closest('.order-single-product')
        .find('select option:selected')
        .data('price');

    let stock = price.stock;

    if ($(this).data('prev-id') == price.id) {
        stock += parseInt($(this).data('prev-quantity'));
    }

    if ($(this).val() > stock) {
        $(this).after(
            `<small class="form-text text-danger stock-alert">تعداد موجودی: ${stock}</small>`
        );
    }
});

function calculate_total_price() {
    let total_price = 0;
    let total_count = 0;
    $('.order-single-product').each(function (index, el) {
        let el_price = parseInt($(el).find('.product-price').val());
        let el_discount = parseInt($(el).find('.product-discount').val());
        let el_quantity = parseInt($(el).find('.product-quantity').val());

        total_price += (el_price - el_discount) * el_quantity;
        total_count++;
    });

    if ($('#caculate_tax').is(':checked')) {
        total_price += total_price * (tax_amount / 100);
    }

    $('#factor_total').text(number_format(total_price));
    $('#factor_count').text(number_format(total_count));
    $('.order-detail').show();
}

$(document).on(
    'change',
    '.order-single-product .price-select,.order-single-product .product-discount,.order-single-product .product-quantity,.order-single-product .product-price, #caculate_tax',
    function () {
        calculate_total_price();
    }
);

document
    .getElementById('order-create-form')
    .addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission on Enter key
        }
    });

$('#order-create-form').submit(function (e) {
    e.preventDefault();

    if ($(this).valid() && !$(this).data('disabled')) {
        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                $('#order-create-form').data('disabled', true);

                Swal.fire({
                    type: 'success',
                    text: 'با موفقیت ثبت شد',
                    showConfirmButton: false,
                    footer: `<a target="_blank" href="${data.print}" class="btn btn-success ml-1 waves-effect waves-light">چاپ</a>
                                <a href="${data.new}" class="btn btn-primary ml-1 waves-effect waves-light">سفارش جدید</a>
                                <a href="${data.edit}" class="btn btn-warning ml-1 waves-effect waves-light">ویرایش</a>`
                });
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
