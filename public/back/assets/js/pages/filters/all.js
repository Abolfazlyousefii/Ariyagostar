$('.filterable-plus').on('click', function() {
    var filterable = $(this).closest('.filterable-area');
    var name = filterable.data('name');
    var id = filterable.data('id');
    var type = filterable.data('type');
    var title = filterable.data('title');

    if ($('#filters-table tbody #' + type + '-spec-tr-' + id).length) {
        return;
    }

    var template = $('#filterable-tr-template').clone();
    var inserted_filterable = $('#filters-table tbody').append(template.html());

    inserted_filterable.find('#filterable-name').html(name).removeAttr('id');
    inserted_filterable.find('#filterable-title').text('( ' + title + ' )').removeAttr('id');
    inserted_filterable.find('#spec-tr').attr('id', type + '-spec-tr-' + id);
    inserted_filterable.find('#customSwitch').attr('id', 'filters[' + filtersCount + '][active]').attr('name', 'filters[' + filtersCount + '][active]');
    inserted_filterable.find('[for=customSwitch]').attr('for', 'filters[' + filtersCount + '][active]');
    inserted_filterable.find('#separator').attr('name', 'filters[' + filtersCount + '][separator]').removeAttr('id');
    inserted_filterable.find('#type').removeAttr('id').attr('name', 'filters[' + filtersCount + '][type]').val(type);
    inserted_filterable.find('#filterableId').removeAttr('id').attr('name', 'filters[' + filtersCount + '][id]').val(id);

    if (type != 'specification') {
        inserted_filterable.find('#specification-options').remove();
    } else {
        inserted_filterable.find('#specification-options').removeAttr('id');
    }

    filtersCount++;
});

$("#search-filterable-input").on("keyup", function() {
    var value = $(this).val().toLowerCase();

    if (value) {
        $('#add-filterable-modal .filterable-area').show();

        $("#add-filterable-modal .filterable-area").filter(function() {
            $(this).toggle($(this).find('.filterable-name').text().toLowerCase().indexOf(value) > -1)
        }).hide();

    } else {
        $('#add-filterable-modal .filterable-area').show();
    }
});

$(document).on('click', '.remove-filter', function() {
    $(this).closest('tr').addClass('animated fadeOut');

    setTimeout(() => {
        $(this).closest('tr').remove();
    }, 500);
});

$('#add-filterable-modal').on('show.bs.modal', function() {
    $('#search-filterable-input').val('').trigger('keyup');

    setTimeout(() => {
        $('#search-filterable-input').focus();
    }, 1000);
});

function filtersSortable() {
    var sortable = $('#filters-table tbody').sortable({
        opacity: .75,
        handle: '.draggable-handler',
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

        update: function() {
            $('.links-sortable').each(function(index, e) {
                saveChanges(index);
            });
        },
    });
}

filtersSortable();