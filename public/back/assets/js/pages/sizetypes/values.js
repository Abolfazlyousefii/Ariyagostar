$('#sizetype-values-form').submit(function (e) {
    e.preventDefault();
    let form = $(this);

    if ($(this).valid() && !$(this).data('disabled')) {
        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function (data) {
                form.data('disabled', true);
                window.location.href = form.data('redirect');
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

$(document).on('click', '.remove-value', function () {
    let value = $(this).closest('.single-value');

    value.addClass('animated flipOutX');

    setTimeout(() => {
        value.remove();
    }, 500);
});

$(document).on('click', '.add-value', function () {
    let template = $('.single-value').first().clone();
    template.addClass('animated flipInX');
    template.find('input').val('');

    ++valuesCount;

    template.find('input').each(function (i, item) {
        $(item).attr(
            'name',
            `values[${valuesCount}][${$(item).data('size-id')}]`
        );
    });

    let value = $('#values-area').append(template);

    valueSortable();

    setTimeout(() => {
        value.find('.single-value').removeClass('animated flipInX');
    }, 700);
});

function valueSortable() {
    $('.all-values').sortable({
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

valueSortable();
