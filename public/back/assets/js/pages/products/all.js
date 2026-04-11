CKEDITOR.config.height = 400;
CKEDITOR.replace('description');

$('.tags').tagsInput({
    defaultText: 'افزودن',
    width: '100%',
    autocomplete_url: $('.tags').data('action')
});

$('.labels').tagsInput({
    defaultText: 'افزودن',
    width: '100%',
    height: '110px',
    autocomplete_url: $('.labels').data('action')
});

$('.product-category').select2ToTree({
    rtl: true,
    width: '100%'
});

$('select.select2').select2({
    rtl: true,
    width: '100%'
});

$('.product-categories').select2ToTree({
    rtl: true,
    width: '100%'
});

// validate form with jquery validation plugin
jQuery('#product-create-form, #product-edit-form').validate({
    rules: {
        title: {
            required: true
        },
        weight: {
            required: true,
            digits: true
        }
    }
});

//------------ specification group js codes

var groupsCount = groupCount;

$('#add-product-specification-group').click(function () {
    var template = $('#specification-group').clone();

    var group = $('#specifications-area').append(template.html());

    var count = ++groupCount;
    groupsCount++;

    var input = group.find('input[name="specification_group"]');

    input.attr('name', 'specification_group[' + count + '][name]');
    input.data('group_name', count);

    groupSortable();

    setTimeout(() => {
        group.find('.specification-group').removeClass('.animated fadeIn');
    }, 700);
});

function groupSortable() {
    $('#specifications-area').sortable({
        opacity: 0.75,
        start: function (e, ui) {
            ui.placeholder.css({
                height: ui.item.outerHeight(),
                'margin-bottom': ui.item.css('margin-bottom')
            });
        },
        helper: function (e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function (index) {
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        }
    });
}

groupSortable();

$(document).on('click', '.remove-group', function () {
    var group = $(this).closest('.specification-group');

    group.addClass('animated fadeOut');

    setTimeout(() => {
        group.remove();
    }, 500);

    groupsCount--;
});

//------------ specifications js codes

$(document).on('click', '.add-specifaction', function () {
    var template = $('#specification-single').clone();

    var specification = $(this)
        .closest('.specification-group')
        .find('.all-specifications')
        .append(template.html());

    var count = ++specificationCount;
    var group_name = $(specification)
        .closest('.specification-group')
        .find('.group-input')
        .data('group_name');

    specification
        .find('input[name="special_specification"]')
        .attr(
            'name',
            'specification_group[' +
                group_name +
                '][specifications][' +
                count +
                '][special]'
        );
    specification
        .find('input[name="specification_name"]')
        .attr(
            'name',
            'specification_group[' +
                group_name +
                '][specifications][' +
                count +
                '][name]'
        );
    specification
        .find('textarea[name="specification_value"]')
        .attr(
            'name',
            'specification_group[' +
                group_name +
                '][specifications][' +
                count +
                '][value]'
        );

    specificationSortable();

    setTimeout(() => {
        specification
            .find('.single-specificition')
            .removeClass('.animated fadeIn');
    }, 700);
});

$(document).on('click', '.remove-specification', function () {
    var specification = $(this).closest('.single-specificition');

    specification.addClass('animated fadeOut');

    setTimeout(() => {
        specification.remove();
    }, 500);
});

function specificationSortable() {
    $('.all-specifications').sortable({
        opacity: 0.75,
        start: function (e, ui) {
            ui.placeholder.css({
                height: ui.item.outerHeight(),
                'margin-bottom': ui.item.css('margin-bottom')
            });
        },
        helper: function (e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function (index) {
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        }
    });
}

specificationSortable();

//------------ files js codes

function addProductFile() {
    var template = $('#files-template').clone();

    var file = $('#product-files-area')
        .append(template.html())
        .find('.single-file:last');
    var count = ++filesCount;

    file.find('input[name="title"]').attr(
        'name',
        'download_files[' + count + '][title]'
    );
    file.find('select[name="status"]').attr(
        'name',
        'download_files[' + count + '][status]'
    );
    file.find('input[name="file"]').attr(
        'name',
        'download_files[' + count + '][file]'
    );
    file.find('input[name="file"]').attr(
        'id',
        'download_files[' + count + '][id]'
    );
    file.find('label[for="file"]').attr(
        'for',
        'download_files[' + count + '][id]'
    );
    file.find('input[name="price"]').attr(
        'name',
        'download_files[' + count + '][price]'
    );
    file.find('input[name="discount"]').attr(
        'name',
        'download_files[' + count + '][discount]'
    );

    filesSortable();

    setTimeout(() => {
        file.removeClass('animated fadeIn');
    }, 700);
}

$(document).on('click', '#add-product-file', function () {
    addProductFile();
});

$(document).on('click', '.remove-file', function () {
    var file = $(this).closest('.single-file');

    file.addClass('animated fadeOut');

    setTimeout(() => {
        file.remove();
    }, 500);
});

if (filesCount == 0) {
    addProductFile();
}

function filesSortable() {
    $('#product-files-area').sortable({
        opacity: 0.75,
        start: function (e, ui) {
            ui.placeholder.css({
                height: ui.item.outerHeight(),
                'margin-bottom': ui.item.css('margin-bottom')
            });
        },
        helper: function (e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function (index) {
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        }
    });
}

filesSortable();

$('#product-type').on('change', function () {
    if ($(this).val() == 'physical') {
        $('.physical-item').show();
        $('.download-item').hide();
    } else {
        $('.physical-item').hide();
        $('.download-item').show();
    }
});

$('#product-type').trigger('change');

//------------ spectype js codes

$('#specifications_type').autocomplete({
    source: availableTypes
});

$('#specifications_type').change(function () {
    var value = $(this).val();

    if (availableTypes.includes(value) && !specifications_type_first_change) {
        addSpecTypeData();
    } else if (availableTypes.includes(value) && groupsCount != 0) {
        $('#specifications-modal').modal('show');
    } else if (availableTypes.includes(value) && groupsCount == 0) {
        addSpecTypeData();
    }

    specifications_type_first_change = true;

    $('#spec-div').show();
});

$('#add-spec-type-data').click(addSpecTypeData);

$('#specifications_type').on('keyup keypress', function (e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        e.preventDefault();
        return false;
    }
});

function addSpecTypeData() {
    $.ajax({
        url: BASE_URL + '/spectypes/spec-type-data',
        type: 'GET',
        data: {
            name: $('#specifications_type').val()
        },
        success: function (data) {
            groupCount = data.groupCount;
            specificationCount = data.specificationCount;
            groupsCount = data.groupCount;

            $('#specifications-area').html(data.view);
            specificationSortable();
            groupSortable();
        },
        beforeSend: function (xhr) {
            block('#specifications-card');
        },
        complete: function () {
            unblock('#specifications-card');
        }
    });
}

//------------ size type js codes

$('#size_type_id').on('change', function () {
    $('#sizes-area').html('');
    $('.add-value').hide();

    if (!$(this).val()) return;

    let select = $(this);

    $.ajax({
        url: select.find('option:selected').data('action'),
        type: 'GET',
        success: function (data) {
            $('#sizes-area').html(data);
            sizeSortable();
            $('.add-value').show();
        },
        beforeSend: function (xhr) {
            block('#sizes-card');
        },
        complete: function () {
            unblock('#sizes-card');
        }
    });
});

$(document).on('click', '.remove-value', function () {
    if ($('.single-value').length == 1) return;

    let value = $(this).closest('.single-value');

    value.addClass('animated fadeOut');

    setTimeout(() => {
        value.remove();
    }, 500);
});

$(document).on('click', '.add-value', function () {
    let template = $('.single-value').first().clone();
    template.addClass('animated fadeIn');
    template.find('input').val('');

    ++sizesCount;

    template.find('input').each(function (i, item) {
        $(item).attr(
            'name',
            `sizes[${sizesCount}][${$(item).data('size-id')}]`
        );
    });

    let value = $('#sizes-area').append(template);

    sizeSortable();

    setTimeout(() => {
        value.find('.single-value').removeClass('animated fadeIn');
    }, 700);
});

function sizeSortable() {
    if ($('.all-sizes').children().length == 0) {
        $('.add-value').hide();
    } else {
        $('.add-value').show();
    }

    $('.all-sizes').sortable({
        opacity: 0.75,
        start: function (e, ui) {
            ui.placeholder.css({
                height: ui.item.outerHeight(),
                'margin-bottom': ui.item.css('margin-bottom')
            });
        },
        helper: function (e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function (index) {
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        }
    });
}

sizeSortable();

//------------ prices js codes

$('#add-product-prices').click(function () {
    addProductPrice();
});

$('#copy-product-prices').click(function () {
    addProductPrice(true);
});

$(document).on('click', '.remove-product-price', function () {
    var price = $(this).closest('.single-price');

    price.addClass('animated fadeOut');

    setTimeout(() => {
        price.remove();
        setColorsImage();
    }, 500);
});

if (priceCount == 0) {
    addProductPrice();
}

function addProductPrice(copy = false) {
    var template = $('#prices-template').clone();

    let lastPrice = $('#product-prices-div').find('.single-price').last();

    data = {
        price: '',
        discount: '',
        cart_max: '',
        cart_min: '',
        stock: ''
    };

    if (copy && lastPrice.length) {
        data.price = lastPrice.find('.price').val();
        data.discount = lastPrice.find('.discount').val();
        data.cart_max = lastPrice.find('.cart_max').val();
        data.cart_min = lastPrice.find('.cart_min').val();
        data.stock = lastPrice.find('.stock').val();

        var selectedIds = [];

        lastPrice
            .find('select.price-attribute-select')
            .each(function (index, el) {
                selectedIds.push($(el).val());
            });
    }

    var price = $('#product-prices-div').append(template.html());

    var count = ++priceCount;
    let unit = price
        .closest('.product-prices-tab')
        .find('select[name="currency_id"] option:selected')
        .data('title');

    price
        .find('select[name="attribute"]')
        .attr('name', 'prices[' + count + '][attributes][]')
        .attr('data-number', count)
        .each(function (index, el) {
            $(el)
                .val(
                    typeof selectedIds != 'undefined' ? selectedIds[index] : ''
                )
                .change();
        });

    price
        .find('input[name="price"]')
        .attr('name', 'prices[' + count + '][price]')
        .data('unit', unit)
        .val(data.price)
        .trigger('keyup');
    price
        .find('input[name="price_image"]')
        .attr('name', 'prices[' + count + '][image]')
        .attr('data-number', count);
    price
        .find('input[name="discount"]')
        .attr('name', 'prices[' + count + '][discount]')
        .val(data.discount);
    price
        .find('input[name="discount_expire_at"]')
        .attr('name', 'prices[' + count + '][discount_expire_at]');
    price
        .find('input[name="cart_max"]')
        .attr('name', 'prices[' + count + '][cart_max]')
        .val(data.cart_max);
    price
        .find('input[name="cart_min"]')
        .attr('name', 'prices[' + count + '][cart_min]')
        .val(data.cart_min);
    price
        .find('input[name="stock"]')
        .attr('name', 'prices[' + count + '][stock]')
        .val(data.stock);
    price
        .find('input[name="discount_expire"]')
        .attr('name', 'prices[' + count + '][discount_expire]');

    setTimeout(() => {
        $('.persian-date-picker').customPersianDate();
        price.find('.single-price').removeClass('.animated fadeIn');

        $('select.select2').select2({
            rtl: true,
            width: '100%'
        });
    }, 700);
}

$('select[name="currency_id"]').on('change', function () {
    var unit = $(this).find(':selected').data('title');

    $('.single-price .amount-input').data('unit', unit).trigger('keyup');
});

$(document).on(
    'keyup',
    '.single-price .price, .single-price .discount',
    function () {
        let unit = $(this)
            .closest('.product-prices-tab')
            .find('select[name="currency_id"] option:selected')
            .data('amount');

        let roundingAmount = $(this)
            .closest('.product-prices-tab')
            .find('select[name="rounding_amount"] option:selected')
            .data('value');

        let roundingType = $(this)
            .closest('.product-prices-tab')
            .find('select[name="rounding_type"] option:selected')
            .data('value');

        let discount = $(this).closest('.single-price').find('.discount').val();

        let price = $(this).closest('.single-price').find('.price').val();

        price = price ? parseFloat(price) : 0;
        unit = parseFloat(unit);
        discount = discount ? parseFloat(discount) : 0;
        roundingAmount =
            roundingAmount != 'no' ? parseFloat(roundingAmount) : 0;

        let finalPrice = (price - price * (discount / 100)) * unit;

        finalPrice = toRoundInt(finalPrice, roundingType, roundingAmount);

        finalPrice = +finalPrice.toFixed(2);

        let finalPriceText = number_format(finalPrice) + ' تومان';

        $(this)
            .closest('.single-price')
            .find('.final-price')
            .val(finalPriceText);
    }
);

$(document).on('change', '.prices-option-div select', function () {
    $('.single-price .price').trigger('keyup');
});

$('.prices-option-div select').trigger('change');

//------------ generate slug

$('#generate-product-slug').click(function (e) {
    e.preventDefault();

    var title = $('input[name="meta_title"]').val();

    $.ajax({
        url: BASE_URL + '/product/slug',
        type: 'POST',
        data: {
            title: title
        },
        success: function (data) {
            $('#slug').val(data.slug);
        },
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                'X-CSRF-TOKEN',
                $('meta[name="csrf-token"]').attr('content')
            );
            $('#slug-spinner').show();
        },
        complete: function () {
            $('#slug-spinner').hide();
        }
    });
});

//------------ dropzone sortable

$('.dropzone-area').sortable({
    items: '.dz-preview',
    opacity: 0.75,
    start: function (e, ui) {
        ui.placeholder.css({
            height: ui.item.outerHeight(),
            'margin-bottom': ui.item.css('margin-bottom')
        });
    },
    helper: function (e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function (index) {
            $(this).width($originals.eq(index).width());
        });
        return $helper;
    }
});

//------------ spectype js codes

$('#brand').autocomplete({
    source: BASE_URL + '/brands/ajax/get',
    delay: 1000
});

//------------ special product js codes

$('input[name="special"]').on('change', function () {
    if ($(this).is(':checked')) {
        $('#special-end-date-container').show();
    } else {
        $('#special-end-date-container').hide();
    }
});

$('input[name="special"]').trigger('change');

//------------ prices color

function setColorsImage() {
    let colorSelects = $('select[data-type="color"]');
    let colors = [];

    colorSelects.each(function (index, el) {
        let option = $(el).find('option:selected');

        if (option.val()) {
            colors.push({name: option.text(), id: option.val()});
        }
    });

    colors = colors.filter(
        (item, index, self) =>
            index ===
            self.findIndex((t) => t.name === item.name && t.id === item.id)
    );

    let dropzoneSelects = $('div#product-images select.color-select');

    if (colors.length) {
        dropzoneSelects.each(function (index, el) {
            $(el).removeClass('d-none');

            let selectedColor = $(el).data('color-id');

            if (selectedColor) {
                $('#product-edit-form').append(
                    `<input type="hidden" name="color_selects[${$(el).data(
                        'image'
                    )}]" value="${$(el).data('color-id')}" />`
                );
            }

            $(el).empty();

            $(el).append('<option value="">انتخاب رنگ</option>');

            colors.forEach(function (el2) {
                let selected = selectedColor == el2.id ? 'selected' : '';

                $(el).append(
                    `<option value="${el2.id}" ${selected}>${el2.name}</option>`
                );
            });
        });
    } else {
        dropzoneSelects.empty().addClass('d-none');
    }
}

setTimeout(() => {
    setColorsImage();
}, 600);

$(document).on(
    'change',
    'div#product-images select.color-select',
    function (e) {
        let select = $(this);

        $('#product-edit-form').append(
            `<input type="hidden" name="color_selects[${select.data(
                'image'
            )}]" value="${select.val()}" />`
        );
        select.data('color-id', select.val());
    }
);

$(document).on('change', 'select[data-type="color"]', function () {
    $(`input[name="prices[${$(this).data('number')}][image]"]`).val('');
    setColorsImage();
});

setTimeout(() => {
    $('select[data-type="color"]').each(function (index, el) {
        let imageInputEl = $(
            `input[name="prices[${$(el).data('number')}][image]"]`
        );

        $(`div[data-name="${imageInputEl.val()}"]`)
            .find('select')
            .val($(el).find('option:selected').text());
    });
}, 500);
