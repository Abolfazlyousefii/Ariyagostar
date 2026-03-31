if ($("#countdown-verify-end").length) {
    var $countdownOptionEnd = $("#countdown-verify-end");

    $countdownOptionEnd.countdown({
        date: resend_time * 1000, // 1 minute later
        text: '<span class="day">%s</span><span class="hour">%s</span><span>: %s</span><span>%s</span>',
        end: function() {
            $countdownOptionEnd.html("<a href='' class='btn-link-border'>ارسال مجدد</a>");
        }
    });
}

$('#verify-username-form').submit(function(e) {
    e.preventDefault();

    if ($(this).valid()) {

        var formData = new FormData(this);
        var form = $(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(data) {
                window.location.href = redirect_url;
            },

            beforeSend: function(xhr) {
                block('.form-ui');
                xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
            },
            complete: function() {
                unblock('.form-ui');
            },

            cache: false,
            contentType: false,
            processData: false
        });
    }
});

$(document).ready(function () {
    $('.activation-code-input').activationCodeInput({
        number: 5
    })
})
