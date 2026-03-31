$('#spectype-edit-form').submit(function(e) {
    e.preventDefault();

    if ($(this).valid() && !$(this).data('disabled')) {


        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(data) {
                $('#spectype-edit-form').data('disabled', true);
                window.location.href = BASE_URL + "/spectypes";
            },
            beforeSend: function(xhr) {
                block('#main-card');
                xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            },
            complete: function() {
                unblock('#main-card');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

});


$('#add-spectype-specification-group').click(function() {
    var template = $('#specification-group').clone();

    var group = $('#specifications-area').append(template.html());

    var count = ++groupCount;

    var input = group.find('input[name="specification_group"]');

    input.attr('name', 'specification_group[' + (count) + '][name]');
    input.data('group_name', count);

    groupSortable();

    setTimeout(() => {
        group.find('.specification-group').removeClass('.animated flipInX');
    }, 700);
});

function groupSortable() {
    $('#specifications-area').sortable({
        opacity: .75,
        start: function(e, ui) {
            ui.placeholder.css({
                'height': ui.item.outerHeight(),
                'margin-bottom': ui.item.css('margin-bottom'),
            });
        },
        helper: function(e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function(index) {
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        },

    });
}

groupSortable();

$(document).on('click', '.remove-group', function() {
    var group = $(this).closest('.specification-group');

    group.addClass('animated flipOutX');

    setTimeout(() => {
        group.remove();
    }, 500);

});

$(document).on('click', '.remove-specification', function() {
    var specification = $(this).closest('.single-specificition');

    specification.addClass('animated flipOutX');

    setTimeout(() => {
        specification.remove();
    }, 500);
});

$(document).on('click', '.add-specifaction', function() {
    var template = $('#specification-single').clone();

    var specification = $(this).closest('.specification-group').find('.all-specifications').append(template.html());

    var count = ++specificationCount;
    var group_name = $(specification).closest('.specification-group').find('.group-input').data('group_name');

    specification.find('input[name="specification_name"]').attr('name', 'specification_group[' + (group_name) + '][specifications][' + count + '][name]');

    specificationSortable();

    setTimeout(() => {
        specification.find('.single-specificition').removeClass('.animated flipInX');
    }, 700);

});

function specificationSortable() {
    $('.all-specifications').sortable({
        opacity: .75,
        start: function(e, ui) {
            ui.placeholder.css({
                'height': ui.item.outerHeight(),
                'margin-bottom': ui.item.css('margin-bottom'),
            });
        },
        helper: function(e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function(index) {
                $(this).width($originals.eq(index).width());
            });
            return $helper;
        },

    });
}

specificationSortable();