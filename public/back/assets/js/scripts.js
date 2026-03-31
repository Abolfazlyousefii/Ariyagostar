function block(el) {
    var $body = $('body');

    var block_ele = $(el);

    var reloadActionOverlay;
    if ($body.hasClass('dark-layout')) {
        var reloadActionOverlay = '#10163a';
    } else {
        var reloadActionOverlay = '#fff';
    }

    // Block Element
    block_ele.block({
        message:
            '<div class="feather icon-refresh-cw icon-spin font-medium-2 text-primary"></div>',
        overlayCSS: {
            backgroundColor: reloadActionOverlay,
            cursor: 'wait'
        },
        css: {
            border: 0,
            padding: 0,
            backgroundColor: 'none'
        }
    });
}

function unblock(el) {
    $(el).unblock();
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    tryCount: 0,
    retryLimit: 3,
    error: async function (data, textStatus, errorThrown) {
        if (data.status == 403) {
            toastr.error('اجازه ی دسترسی ندارید', 'خطا');
            return;
        } else if (data.status == 419) {
            this.tryCount++;
            if (this.tryCount <= this.retryLimit) {
                //try again

                await refreshCsrf();

                this.headers = {
                    ...this.headers,
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                };

                if (this.data && this.data.set) {
                    this.data.set(
                        '_token',
                        $('meta[name="csrf-token"]').attr('content')
                    );
                }

                $.ajax(this);

                return;
            }
            return;
        } else if (data.status == 429) {
            toastr.error(
                'تعداد درخواست ها بیش از حد مجاز است لطفا پس از دقایقی مجدد تلاش کنید',
                'خطا'
            );
        } else if (data.status == 423) {
            if ($('#password-confirm-modal').length) {
                $('#password-confirm-modal').modal('show');
                $('#password-confirm-modal').data('ajax', this);
            } else {
                toastr.error('لطفا رمز عبور خود را وارد کنید');
            }
            return;
        } else if (!data.responseJSON?.errors) {
            toastr.error('خطایی رخ داده است', 'خطا');

            if ($('#main-errors-modal').length) {
                if (data.responseJSON) {
                    new JsonEditor(
                        '#main-errors-modal .modal-body .error-content',
                        data.responseJSON
                    );

                    setTimeout(() => {
                        $(
                            '#main-errors-modal .modal-body .error-content .json-toggle'
                        )
                            .first()
                            .trigger('click');
                    }, 500);
                } else {
                    $('#main-errors-modal .modal-body .error-content').html(
                        data.responseText
                    );
                }

                $('#main-errors-modal').modal('show');
            }

            return;
        }

        for (var key in data.responseJSON.errors) {
            // skip loop if the property is from prototype
            if (!data.responseJSON.errors.hasOwnProperty(key)) continue;

            var obj = data.responseJSON.errors[key];
            for (var prop in obj) {
                // skip loop if the property is from prototype
                if (!obj.hasOwnProperty(prop)) continue;

                toastr.error(obj[prop], 'خطا');
            }
        }
    }
});

function reloadDiv(el) {
    //get current url
    var url = window.location.href;

    //refresh comments list
    $(el).load(url + ' ' + el + ' > *');
}

String.prototype.toEnglishDigit = function () {
    var find = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    var replace = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    var replaceString = this;
    var regex;
    for (var i = 0; i < find.length; i++) {
        regex = new RegExp(find[i], 'g');
        replaceString = replaceString.replace(regex, replace[i]);
    }
    return replaceString;
};

$('#video-helpe-modal').on('show.bs.modal', function () {
    $('#video-helpe-modal iframe').each(function () {
        var src = $(this).data('src');
        $(this).attr('src', src);
    });
});

$('#video-helpe-modal').on('hide.bs.modal', function () {
    $('#video-helpe-modal iframe').each(function () {
        var src = $(this).attr('src');
        $(this).attr('src', src);
    });
});

$('#video-helpe-modal .collapse-header').on('click', function () {
    $('#video-helpe-modal iframe').each(function () {
        var src = $(this).attr('src');
        $(this).attr('src', src);
    });
});

//---------------- amount input
$('.amount-input').attr('autocomplete', 'off');

$(document).on('keyup', '.amount-input', function () {
    if (!$(this).val()) {
        $(this).next('.form-text').remove();
        return;
    }

    if (!$(this).next('.form-text').length) {
        $(this).after(
            '<small class="form-text text-success amount-helper"></small>'
        );
    }

    var text =
        number_format($(this).val()) +
        ' ' +
        ($(this).data('unit') ? $(this).data('unit') : 'تومان');

    $(this).next('.form-text').text(text);
});

$('.amount-input').trigger('keyup');

if (typeof persianDate != 'undefined') {
    $('.persian-date-picker').customPersianDate();
}

$('#password-confirm-form').on('submit', function (e) {
    e.preventDefault();

    var form = $(this);
    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function (data) {
            $('#password-confirm-modal').modal('hide');
            $.ajax($('#password-confirm-modal').data('ajax'));
            form.trigger('reset');
        },
        beforeSend: function (xhr) {
            block(form);
        },
        complete: function () {
            unblock(form);
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

function refreshCsrf() {
    return $.ajax({
        url: $('meta[name="csrf-token"]').data('refresh-url'),
        type: 'GET',
        success: function (data) {
            $('input[name="_token"]').val(data);
            $('meta[name="csrf-token"]').attr('content', data);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

$('.card-header.filter-card').on('click', function (e) {
    console.log('sdfsdf     ');
    if (!$(e.target).closest('a[data-action="collapse"]').length) {
        $(this)
            .find('.heading-elements a[data-action="collapse"]')
            .trigger('click');
    }
});

$('#province, #city').select2({
    rtl: true,
    width: '100%'
});

$('select.select2').select2({
    rtl: true,
    width: '100%'
});

$('#province').change(function () {
    var id = $(this).find(':selected').val();

    if (!id) return;

    $('#city').empty();

    $.ajax({
        type: 'get',
        url: $('#province').data('action'),
        data: {id: id},
        success: function (data) {
            $(data).each(function () {
                selected =
                    $(this)[0].id == $('#city').data('id') ? 'selected' : '';

                $('#city').append(
                    `<option value="${$(this)[0].id}" ${selected}>${
                        $(this)[0].name
                    }</option>`
                );
            });
        },
        beforeSend: function () {
            block('#city-div');
        },
        complete: function () {
            unblock('#city-div');
        }
    });
});

$('.ajax-form').on('submit', function (e) {
    e.preventDefault();
    var form = $(this);

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        success: function (data) {
            if (data == 'success') {
                window.location.href = form.data('redirect');
            }
        },
        beforeSend: function (xhr) {
            block(form);
            xhr.setRequestHeader(
                'X-CSRF-TOKEN',
                $('meta[name="csrf-token"]').attr('content')
            );
        },
        complete: function () {
            unblock(form);
        },
        cache: false,
        contentType: false,
        processData: false
    });
});
