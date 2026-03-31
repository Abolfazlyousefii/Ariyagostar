var data = [];

$.each(provinces, function (index, province) {
    let cities = [];
    let checked = false;

    $.each(province.cities, function (index, city) {
        cities.push({
            id: city.id,
            title: city.name
        });

        if (selected_cities.includes(city.id)) {
            checked = true;
        }
    });

    let p = {
        id: 'province_' + province.id,
        title: province.name,
        subs: cities
    };

    if (checked) {
        selected_cities.push('province_' + province.id);
    }

    data.push(p);
});

var comboProvinces;

jQuery(document).ready(function ($) {
    comboProvinces = $('#included-cities').comboTree({
        source: data,
        isMultiple: true,
        cascadeSelect: true,
        collapse: true,
        selected: selected_cities
    });
});

$('#province, #city').select2({
    rtl: true,
    width: '100%'
});

$('#province').change(function () {
    var id = $(this).find(':selected').val();

    $('#city').empty();

    if (!id) {
        return;
    }

    $.ajax({
        type: 'GET',
        url: $('#province').data('action'),
        data: {id: id},
        success: function (data) {
            $(data).each(function (i, item) {
                $('#city').append(
                    '<option value="' + item.id + '">' + item.name + '</option>'
                );
            });
        },
        beforeSend: function () {
            block('#city');
        },
        complete: function () {
            unblock('#city');
        }
    });
});

$('select[name="covered_cities"]')
    .on('change', function () {
        if ($(this).val() == 'all') {
            $('#included-cities-container').hide();
        } else {
            $('#included-cities-container').show();
        }
    })
    .trigger('change');
