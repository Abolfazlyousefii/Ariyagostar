CKEDITOR.inline('description');

$('#sizetype-form').submit(function (e) {
    e.preventDefault();
    let form = $(this);

    if ($(this).valid() && !$(this).data('disabled')) {
        var formData = new FormData(this);
        formData.append(
            'description',
            CKEDITOR.instances['description'].getData()
        );

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

$(document).on('click', '.remove-size', function () {
    if ($('.single-size').length == 1) {
        return;
    }

    var size = $(this).closest('.single-size');

    size.addClass('animated flipOutX');

    setTimeout(() => {
        size.remove();
    }, 500);
});

$(document).on('click', '.add-size', function () {
    var template = $('.single-size').first().clone();

    template.addClass('animated flipInX');
    template.find('input').attr('name', `sizes[${++sizeCount}]`);
    template.find('input').val('');
    template.find('input[type="hidden"]').remove();

    var size = $('.all-sizes').append(template);

    sizeSortable();

    setTimeout(() => {
        size.find('.single-size').removeClass('animated flipInX');
    }, 700);
});

function sizeSortable() {
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
