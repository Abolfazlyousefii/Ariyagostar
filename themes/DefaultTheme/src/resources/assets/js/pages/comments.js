$('#comments-form').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var btn = $('.comment-submit-btn');

    var formData = new FormData(this);

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        success: function(data) {
            Swal.fire({
                text: 'نظر شما با موفقیت ثبت شد و پس از تایید نمایش داده خواهد شد.',
                type: 'success',
                showCancelButton: false,
                confirmButtonText: 'باشه',
            });

            form.trigger('reset');

            $('.comment-replay-to').hide();
        },

        beforeSend: function(xhr) {
            xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            block(btn);
        },
        complete: function() {
            unblock(btn);
        },

        cache: false,
        contentType: false,
        processData: false
    });

});

$('.comment-replay').click(function(e) {
    e.preventDefault();
    var a = $(this);

    $('.comment-replay-to').find('span').text('در پاسخ به: ' + a.data('name'));
    $('#comments-form input[name="comment_id"]').val(a.data('id'));
    $('.comment-replay-to').show();

    $('html, body').animate({
        scrollTop: $(".comment--form").offset().top
    }, 700);

    $('#comments-form textarea').focus();
});

$('.comment-replay-to a').click(function(e) {
    e.preventDefault();
    $('#comments-form input[name="comment_id"]').val('');
    $('.comment-replay-to').hide();
})