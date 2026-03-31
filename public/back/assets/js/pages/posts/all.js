// generate slug

$('#generate-post-slug').click(function(e) {
    e.preventDefault();

    var title = $('input[name="meta_title"]').val();

    $.ajax({
        url: BASE_URL + '/post/slug',
        type: 'POST',
        data: {
            title: title
        },
        success: function(data) {
            $('#slug').val(data.slug);
        },
        beforeSend: function(xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            $('#slug-spinner').show();
        },
        complete: function() {
            $('#slug-spinner').hide();
        }
    });
});

//------------ publish time picker js codes

$('#publish_date_picker').on('keydown', function(e) {
    e.preventDefault();
    $(this).val('');
    $('#publish_date').val('');
});