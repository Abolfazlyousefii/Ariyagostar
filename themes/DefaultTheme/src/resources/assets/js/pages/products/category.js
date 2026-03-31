$('#products-filter-form').on('submit', function (e) {
    e.preventDefault();

    var formData = new FormData(this);

    var sortType = $(
        '.products-list-sort-type .ah-tab-item[data-ah-tab-active="true"]'
    ).data('sort');

    formData.append('sort_type', sortType);

    var queryString = new URLSearchParams(formData).toString();

    reloadProductsList(
        $('#category-products-div').data('action') + '?' + queryString
    );
});

$('#products-filter-form input').on('change', function () {
    $('#products-filter-form').trigger('submit');
});

function reloadProductsList(url) {
    $.ajax({
        type: 'GET',
        url: url,
        success: function (data) {
            let content = $(data).find('#category-products-div').html();

            $('#category-products-div').html(content);

            window.history.pushState({}, '', url);

            $('html, body').animate(
                {
                    scrollTop: $('#category-products-div').offset().top - 20
                },
                1000
            );

            horizontalMenu();
        },
        beforeSend: function (xhr) {
            block('#category-products-div');
        },
        complete: function () {
            unblock('#category-products-div');
        }
    });
}

$(document).on('click', '#category-products-div .pagination a', function (e) {
    e.preventDefault();
    reloadProductsList($(this).attr('href'));
});

$(window).on('popstate', function (e) {
    location.reload();
});

function horizontalMenu() {
    $('.products-list-sort-type').horizontalmenu({
        itemClick: function (item) {
            if ($(item).attr('data-ah-tab-active') == 'true') {
                return false;
            }

            $('.ah-tab-content-wrapper .ah-tab-content').removeAttr(
                'data-ah-tab-active'
            );

            $(
                '.ah-tab-content-wrapper .ah-tab-content:eq(' +
                    $(item).index() +
                    ')'
            ).attr('data-ah-tab-active', 'true');

            if (!$('#products-filter-form').length) {
                let queryString = 'sort_type=' + $(item).data('sort');

                reloadProductsList(
                    $('#category-products-div').data('action') +
                        '?' +
                        queryString
                );

                return false;
            }

            setTimeout(() => {
                $('#products-filter-form').trigger('submit');
            }, 200);

            return false; //if this finction return true then will be executed http request
        }
    });
}

horizontalMenu();

$('.attribute_group_input').on('change', function () {
    if ($(this).prop('checked')) {
        $('.in_stock').prop('checked', true);
    }
});

$(document).ready(function () {
    if ($('#slider-non-linear-step').length) {
        var nonLinearStepSlider = document.getElementById(
            'slider-non-linear-step'
        );

        noUiSlider.create(nonLinearStepSlider, {
            start: [selected_min_price, selected_max_price],
            connect: true,
            direction: 'rtl',
            format: wNumb({
                decimals: 0,
                thousand: ','
            }),
            range: {
                min: [products_min_price],
                max: [products_max_price]
            }
        });
        var nonLinearStepSliderValueElement = document.getElementById(
            'slider-non-linear-step-value'
        );

        nonLinearStepSlider.noUiSlider.on('update', function (values) {
            $('input[name="min_price"]').val(values[0].replaceAll(',', ''));
            $('input[name="max_price"]').val(values[1].replaceAll(',', ''));

            nonLinearStepSliderValueElement.innerHTML = values.join(' - ');
        });

        nonLinearStepSlider.noUiSlider.on('change', function (values) {
            $('.in_stock').prop('checked', true);
            $('.price_filter').prop('checked', true);
        });
    }
});
