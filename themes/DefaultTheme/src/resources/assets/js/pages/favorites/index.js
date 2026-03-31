$('.favorite-remove-btn').on('click', function() {
    $('#favorite-remove-form').attr('action', $(this).data('action'));
});