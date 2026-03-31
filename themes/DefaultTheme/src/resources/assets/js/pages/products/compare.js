$('#compare-products-form').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);

    var formData = new FormData(this);

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        success: function(data) {
            var content = $(data).find('.products-row').first().html();

            $('.compare-modal .products-row').html(content);
            $(window).lazyLoadXT();
        },
        beforeSend: function(xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        cache: false,
        contentType: false,
        processData: false
    });

});