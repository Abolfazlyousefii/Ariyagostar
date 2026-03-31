$(document).ready(function (l) {
    // **************  fixed header
    $(window).scroll(function () {
        if ($(this).scrollTop() > 60) {
            $('header.main-header.js-fixed-header').addClass('fixed');
            $('header.main-header.js-fixed-topbar').addClass(
                'fixed fixed-topbar'
            );
        } else {
            $('header.main-header.js-fixed-header').removeClass('fixed');
            $('header.main-header.js-fixed-topbar').removeClass(
                'fixed fixed-topbar'
            );
        }
    });

    // **************  category slider
    $('.category-slider').owlCarousel({
        rtl: IS_RTL ? true : false,
        margin: 10,
        nav: true,
        navText: [
            '<i class="mdi mdi mdi-chevron-right"></i>',
            '<i class="mdi mdi mdi-chevron-left"></i>'
        ],
        dots: false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
                slideBy: 1
            },
            576: {
                items: 3,
                slideBy: 2
            },
            768: {
                items: 4,
                slideBy: 2
            },
            992: {
                items: 6,
                slideBy: 3
            },
            1400: {
                items: 8,
                slideBy: 4
            }
        }
    });
    // ************** carousel-products
    $('.carousel-products').owlCarousel({
        rtl: IS_RTL ? true : false,
        margin: 10,
        nav: true,
        // autoWidth: true,
        navText: [
            '<i class="mdi mdi mdi-chevron-right"></i>',
            '<i class="mdi mdi mdi-chevron-left"></i>'
        ],
        dots: false,
        stagePadding: 1,
        responsiveClass: true,
        responsive: {
            0: {
                items: 3,
                slideBy: 1
            },
            576: {
                items: 4,
                slideBy: 1
            },
            768: {
                items: 6,
                slideBy: 1
            },
            991: {
                items: 7,
                slideBy: 1
            },
            992: {
                items: 3,
                slideBy: 1
            },
            1400: {
                items: 6,
                slideBy: 1
            }
        }
    });

    /* **************  tooltip */
    $('[data-toggle="tooltip"]').tooltip();

    /* **************  product-carousel */
    /* carousel-lg */
    $('.carousel-lg').owlCarousel({
        rtl: IS_RTL ? true : false,
        margin: 10,
        nav: true,
        navText: [
            '<i class="mdi mdi mdi-chevron-right"></i>',
            '<i class="mdi mdi mdi-chevron-left"></i>'
        ],
        dots: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
                slideBy: 1
            },
            480: {
                items: 2,
                slideBy: 1
            },
            576: {
                items: 3,
                slideBy: 1
            },
            768: {
                items: 4,
                slideBy: 2
            },
            992: {
                items: 4,
                slideBy: 2
            },
            1200: {
                items: 6,
                slideBy: 3
            },
            1400: {
                items: 6,
                slideBy: 4
            }
        }
    });
    /* carousel-thumbnails */
    $('.carousel-thumbnails').owlCarousel({
        rtl: IS_RTL ? true : false,
        margin: 10,
        nav: false,
        navText: [
            '<i class="mdi mdi mdi-chevron-right"></i>',
            '<i class="mdi mdi mdi-chevron-left"></i>'
        ],
        dots: false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
                slideBy: 1
            },
            480: {
                items: 2,
                slideBy: 1
            },
            576: {
                items: 3,
                slideBy: 1
            },
            768: {
                items: 3,
                slideBy: 1
            },
            992: {
                items: 3,
                slideBy: 1
            },
            1200: {
                items: 4,
                slideBy: 1
            },
            1400: {
                items: 4,
                slideBy: 1
            }
        }
    });

    /* profile-order-steps */
    $('.profile-order-steps').owlCarousel({
        rtl: IS_RTL ? true : false,
        margin: 10,
        nav: true,
        navText: [
            '<i class="mdi mdi mdi-chevron-right"></i>',
            '<i class="mdi mdi mdi-chevron-left"></i>'
        ],
        dots: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
                slideBy: 1
            },
            480: {
                items: 2,
                slideBy: 1
            },
            576: {
                items: 3,
                slideBy: 1
            },
            768: {
                items: 3,
                slideBy: 2
            },
            992: {
                items: 3,
                slideBy: 2
            },
            1200: {
                items: 3,
                slideBy: 3
            },
            1400: {
                items: 3,
                slideBy: 4
            }
        }
    });
    /* carousel-sm */
    $('.carousel-sm').owlCarousel({
        rtl: IS_RTL ? true : false,
        margin: 10,
        nav: true,
        navText: [
            '<i class="mdi mdi mdi-chevron-right"></i>',
            '<i class="mdi mdi mdi-chevron-left"></i>'
        ],
        dots: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
                slideBy: 1
            },
            480: {
                items: 2,
                slideBy: 1
            },
            576: {
                items: 3,
                slideBy: 1
            },
            768: {
                items: 3,
                slideBy: 2
            },
            992: {
                items: 9,
                slideBy: 2
            },
            1200: {
                items: 9,
                slideBy: 3
            },
            1400: {
                items: 7,
                slideBy: 4
            }
        }
    });
    /* carousel-md */
    $('.carousel-md').owlCarousel({
        rtl: IS_RTL ? true : false,
        margin: 10,
        nav: true,
        navText: [
            '<i class="mdi mdi mdi-chevron-right"></i>',
            '<i class="mdi mdi mdi-chevron-left"></i>'
        ],
        dots: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
                slideBy: 1
            },
            480: {
                items: 2,
                slideBy: 1
            },
            576: {
                items: 3,
                slideBy: 1
            },
            768: {
                items: 4,
                slideBy: 2
            },
            992: {
                items: 4,
                slideBy: 2
            },
            1200: {
                items: 6,
                slideBy: 3
            },
            1400: {
                items: 6,
                slideBy: 4
            }
        }
    });

    /* ************** suggestion-slider */
    $('#suggestion-slider').owlCarousel({
        rtl: IS_RTL ? true : false,
        items: 1,
        autoplay: true,
        autoplayTimeout: 5000,
        loop: true,
        dots: true,
        onInitialized: startProgressBar,
        onTranslate: resetProgressBar,
        onTranslated: startProgressBar
    });

    function startProgressBar() {
        // apply keyframe animation
        $('.slide-progress').css({
            width: '100%',
            transition: 'width 5000ms'
        });
    }

    function resetProgressBar() {
        $('.slide-progress').css({
            width: 0,
            transition: 'width 0s'
        });
    }

    /* ************** product-gallery */
    var e = document;
    $('.product-carousel').owlCarousel({
        rtl: IS_RTL ? true : false,
        items: 1,
        loop: false,
        dots: false,
        nav: true,
        navText: [
            '<i class="mdi mdi mdi-chevron-right"></i>',
            '<i class="mdi mdi mdi-chevron-left"></i>'
        ],
        onTranslate: function (t) {
            var a = t.item.index,
                e = l('.product-gallery .owl-item')
                    .eq(a)
                    .find('[data-owl]')
                    .attr('data-owl');
            l('.product-thumbnails li ').removeClass('active'),
                l('[href="#' + e + '"]')
                    .parent()
                    .addClass('active'),
                l('[data-owl="' + e + '"]')
                    .parent()
                    .addClass('active');
        }
    });

    if ($.fancybox != undefined) {
        $.fancybox.defaults.hash = false;
        $('.gallery-item').fancybox({
            // hash: true,
            loop: true,
            keyboard: true,
            clickContent: false,
            afterShow: function (e, b) {
                $(
                    `.product-thumbnails .owl-thumbnail[data-slide="${e.currIndex}"]`
                ).trigger('click');
            }
        });
    }

    $('.owl-thumbnail').click(function (e) {
        e.preventDefault();
        var slide = $(this).data('slide');

        $('.product-gallery .product-carousel').trigger(
            'to.owl.carousel',
            slide
        );
    });

    /* ************** sidebar-sticky */
    if ($('.container .sticky-sidebar').length) {
        $('.container .sticky-sidebar').theiaStickySidebar({
            additionalMarginTop: 20
        });
    }

    /* ************** product-params */
    $(document).on('click', '.product-params .sum-more', function () {
        var sumaryBox = $(this).parents('.product-params');
        sumaryBox.toggleClass('active');

        $(this).find('i').toggleClass('active');

        $(this).find('.show-more').fadeToggle(0);
        $(this).find('.show-less').fadeToggle(0);
    });

    /* ************** horizontal-menu */
    $('.ah-tab-wrapper').horizontalmenu({
        itemClick: function (item) {
            $('.ah-tab-content-wrapper .ah-tab-content').removeAttr(
                'data-ah-tab-active'
            );
            $(
                '.ah-tab-content-wrapper .ah-tab-content:eq(' +
                    $(item).index() +
                    ')'
            ).attr('data-ah-tab-active', 'true');
            return false; //if this finction return true then will be executed http request
        }
    });

    /* ************** shopping */
    $('#btn-checkout-contact-location').click(function () {
        $('.checkout-address').addClass('show');
        $('.checkout-contact-content').addClass('hidden');
    });

    $('#cancel-change-address-btn').click(function () {
        $('.checkout-address').removeClass('show');
        $('.checkout-contact-content').removeClass('hidden');
    });

    /* ************** nice-select */
    if ($('.custom-select-ui').length) {
        // customize nice select

        function standardizePersianLetters(str) {
            var persianMap = {
                ك: 'ک',
                ي: 'ی',
                ى: 'ی',
                ة: 'ه',
                أ: 'ا',
                إ: 'ا',
                آ: 'ا'
            };
            return str.replace(/[ككيىةأإآ]/g, function (match) {
                return persianMap[match];
            });
        }

        (function ($) {
            $.fn.niceSelect = function (method) {
                // Methods
                if (typeof method == 'string') {
                    if (method == 'update') {
                        this.each(function () {
                            var $select = $(this);
                            var $dropdown = $(this).next('.nice-select');
                            var open = $dropdown.hasClass('open');

                            if ($dropdown.length) {
                                $dropdown.remove();
                                create_nice_select($select);

                                if (open) {
                                    $select.next().trigger('click');
                                }
                            }
                        });
                    } else if (method == 'destroy') {
                        this.each(function () {
                            var $select = $(this);
                            var $dropdown = $(this).next('.nice-select');

                            if ($dropdown.length) {
                                $dropdown.remove();
                                $select.css('display', '');
                            }
                        });
                        if ($('.nice-select').length == 0) {
                            $(document).off('.nice_select');
                        }
                    } else {
                        console.log('Method "' + method + '" does not exist.');
                    }
                    return this;
                }

                // Hide native select
                this.hide();

                // Create custom markup
                this.each(function () {
                    var $select = $(this);

                    if (!$select.next().hasClass('nice-select')) {
                        create_nice_select($select);
                    }
                });

                function create_nice_select($select) {
                    $select.after(
                        $('<div></div>')
                            .addClass('nice-select')
                            .addClass($select.attr('class') || '')
                            .addClass(
                                $select.attr('disabled') ? 'disabled' : ''
                            )
                            .addClass(
                                $select.attr('multiple') ? 'has-multiple' : ''
                            )
                            .attr(
                                'tabindex',
                                $select.attr('disabled') ? null : '0'
                            )
                            .html(
                                $select.attr('multiple')
                                    ? '<span class="multiple-options"></span><div class="nice-select-search-box"><input type="text" class="nice-select-search" placeholder="جستجو..."/></div><ul class="list"></ul>'
                                    : '<span class="current"></span><div class="nice-select-search-box"><input type="text" class="nice-select-search" placeholder="جستجو..."/></div><ul class="list"></ul>'
                            )
                    );

                    var $dropdown = $select.next();
                    var $options = $select.find('option');
                    if ($select.attr('multiple')) {
                        var $selected = $select.find('option:selected');
                        var $selected_html = '';
                        $selected.each(function () {
                            $selected_option = $(this);
                            $selected_text =
                                $selected_option.data('display') ||
                                $selected_option.text();

                            if (!$selected_option.val()) {
                                return;
                            }

                            $selected_html +=
                                '<span class="current">' +
                                $selected_text +
                                '</span>';
                        });
                        $select_placeholder =
                            $select.data('js-placeholder') ||
                            $select.attr('js-placeholder');
                        $select_placeholder = !$select_placeholder
                            ? 'Select'
                            : $select_placeholder;
                        $selected_html =
                            $selected_html === ''
                                ? $select_placeholder
                                : $selected_html;
                        $dropdown
                            .find('.multiple-options')
                            .html($selected_html);
                    } else {
                        var $selected = $select.find('option:selected');
                        $dropdown
                            .find('.current')
                            .html(
                                $selected.data('display') || $selected.text()
                            );
                    }

                    $options.each(function (i) {
                        var $option = $(this);
                        var display = $option.data('display');

                        $dropdown.find('ul').append(
                            $('<li></li>')
                                .attr('data-value', $option.val())
                                .attr('data-display', display || null)
                                .addClass(
                                    'option' +
                                        ($option.is(':selected')
                                            ? ' selected'
                                            : '') +
                                        ($option.is(':disabled')
                                            ? ' disabled'
                                            : '')
                                )
                                .html($option.text())
                        );
                    });
                }

                /* Event listeners */

                // Unbind existing events in case that the plugin has been initialized before
                $(document).off('.nice_select');

                // Open/close
                $(document).on(
                    'click.nice_select',
                    '.nice-select',
                    function (event) {
                        var $dropdown = $(this);

                        $('.nice-select').not($dropdown).removeClass('open');
                        $dropdown.toggleClass('open');

                        if ($dropdown.hasClass('open')) {
                            $dropdown.find('.option');
                            $dropdown.find('.nice-select-search').val('');
                            $dropdown.find('.nice-select-search').focus();
                            $dropdown.find('.focus').removeClass('focus');
                            $dropdown.find('.selected').addClass('focus');
                            $dropdown.find('ul li').show();
                        } else {
                            $dropdown.focus();
                        }
                    }
                );

                $(document).on(
                    'click',
                    '.nice-select-search-box',
                    function (event) {
                        event.stopPropagation();
                        return false;
                    }
                );
                $(document).on(
                    'keyup.nice-select-search',
                    '.nice-select',
                    function () {
                        var $self = $(this);
                        var $text = standardizePersianLetters(
                            $self
                                .find('.nice-select-search')
                                .val()
                                .toLowerCase()
                        );
                        var $options = $self.find('ul li');
                        if ($text == '') $options.show();
                        else if ($self.hasClass('open')) {
                            var $matchReg = new RegExp($text);
                            if (0 < $options.length) {
                                $options.each(function () {
                                    var $this = $(this);
                                    var $optionText = standardizePersianLetters(
                                        $this.text().toLowerCase()
                                    );
                                    var $matchCheck =
                                        $matchReg.test($optionText);
                                    $matchCheck ? $this.show() : $this.hide();
                                });
                            } else {
                                $options.show();
                            }
                        }
                        $self.find('.option'),
                            $self.find('.focus').removeClass('focus'),
                            $self.find('.selected').addClass('focus');
                    }
                );

                // Close when clicking outside
                $(document).on('click.nice_select', function (event) {
                    if ($(event.target).closest('.nice-select').length === 0) {
                        $('.nice-select').removeClass('open').find('.option');
                    }
                });

                // Option click
                $(document).on(
                    'click.nice_select',
                    '.nice-select .option:not(.disabled)',
                    function (event) {
                        var $option = $(this);
                        var $dropdown = $option.closest('.nice-select');
                        if ($dropdown.hasClass('has-multiple')) {
                            if ($option.hasClass('selected')) {
                                $option.removeClass('selected');
                            } else {
                                $option.addClass('selected');
                            }
                            $selected_html = '';
                            $selected_values = [];
                            $dropdown.find('.selected').each(function () {
                                $selected_option = $(this);
                                var attrValue = $selected_option.data('value');
                                var text =
                                    $selected_option.data('display') ||
                                    $selected_option.text();
                                $selected_html += `<span class="current" data-id=${attrValue}> ${text} <span class="remove">X</span></span>`;
                                $selected_values.push(
                                    $selected_option.data('value')
                                );
                            });
                            $select_placeholder =
                                $dropdown
                                    .prev('select')
                                    .data('js-placeholder') ||
                                $dropdown.prev('select').attr('js-placeholder');
                            $select_placeholder = !$select_placeholder
                                ? 'Select'
                                : $select_placeholder;
                            $selected_html =
                                $selected_html === ''
                                    ? $select_placeholder
                                    : $selected_html;
                            $dropdown
                                .find('.multiple-options')
                                .html($selected_html);
                            $dropdown
                                .prev('select')
                                .val($selected_values)
                                .trigger('change');
                        } else {
                            $dropdown.find('.selected').removeClass('selected');
                            $option.addClass('selected');
                            var text =
                                $option.data('display') || $option.text();
                            $dropdown.find('.current').text(text);
                            $dropdown
                                .prev('select')
                                .val($option.data('value'))
                                .trigger('change');
                        }
                        console.log($('.mySelect').val());
                    }
                );
                //---------remove item
                $(document).on('click', '.remove', function () {
                    var $dropdown = $(this).parents('.nice-select');
                    var clickedId = $(this).parent().data('id');
                    $dropdown.find('.list li').each(function (index, item) {
                        if (clickedId == $(item).attr('data-value')) {
                            $(item).removeClass('selected');
                        }
                    });
                    $selected_values.forEach(function (item, index, object) {
                        if (item === clickedId) {
                            object.splice(index, 1);
                        }
                    });
                    $(this).parent().remove();
                    console.log($('.mySelect').val());
                });

                // Keyboard events
                $(document).on(
                    'keydown.nice_select',
                    '.nice-select',
                    function (event) {
                        var $dropdown = $(this);
                        var $focused_option = $(
                            $dropdown.find('.focus') ||
                                $dropdown.find('.list .option.selected')
                        );

                        // Space or Enter
                        if (event.keyCode == 32 || event.keyCode == 13) {
                            if ($dropdown.hasClass('open')) {
                                $focused_option.trigger('click');
                            } else {
                                $dropdown.trigger('click');
                            }
                            return false;
                            // Down
                        } else if (event.keyCode == 40) {
                            if (!$dropdown.hasClass('open')) {
                                $dropdown.trigger('click');
                            } else {
                                var $next = $focused_option
                                    .nextAll('.option:not(.disabled)')
                                    .first();
                                if ($next.length > 0) {
                                    $dropdown
                                        .find('.focus')
                                        .removeClass('focus');
                                    $next.addClass('focus');
                                }
                            }
                            return false;
                            // Up
                        } else if (event.keyCode == 38) {
                            if (!$dropdown.hasClass('open')) {
                                $dropdown.trigger('click');
                            } else {
                                var $prev = $focused_option
                                    .prevAll('.option:not(.disabled)')
                                    .first();
                                if ($prev.length > 0) {
                                    $dropdown
                                        .find('.focus')
                                        .removeClass('focus');
                                    $prev.addClass('focus');
                                }
                            }
                            return false;
                            // Esc
                        } else if (event.keyCode == 27) {
                            if ($dropdown.hasClass('open')) {
                                $dropdown.trigger('click');
                            }
                            // Tab
                        } else if (event.keyCode == 9) {
                            if ($dropdown.hasClass('open')) {
                                return false;
                            }
                        }
                    }
                );

                // Detect CSS pointer-events support, for IE <= 10. From Modernizr.
                var style = document.createElement('a').style;
                style.cssText = 'pointer-events:auto';
                if (style.pointerEvents !== 'auto') {
                    $('html').addClass('no-csspointerevents');
                }

                return this;
            };

            $('.custom-select-ui select').niceSelect();
        })(jQuery);
    }

    /* ************** back-to-top */
    $('.back-to-top a').click(function () {
        $('body,html').animate(
            {
                scrollTop: 0
            },
            700
        );
        return false;
    });

    /* ************** responsive-header */
    $('header.main-header button.btn-menu').click(function () {
        $('header.main-header .side-menu').addClass('open');
        $('header.main-header .overlay-side-menu').addClass('show');
    });

    $('header.main-header .overlay-side-menu.show').click(function () {
        $(this).removeClass('show');
        $('header.main-header .side-menu').removeClass('open');
    });
    $('button.btn-menu').on('click', function () {
        $('.overlay-side-menu').fadeIn(200);
        $('header.main-header .side-menu').addClass('open');
    });

    $('.overlay-side-menu').on('click', function () {
        if ($('header.main-header .side-menu').hasClass('open')) {
            $('header.main-header .side-menu').removeClass('open');
        }
        $(this).fadeOut(200);
    });
    $('header.main-header .side-menu li.active')
        .addClass('open')
        .children('ul')
        .show();
    $('header.main-header .side-menu li.sub-menu> a').on('click', function () {
        $(this).removeAttr('href');
        var e = $(this).parent('li');
        if (e.hasClass('open')) {
            e.removeClass('open');
            e.find('li').removeClass('open');
            e.find('ul').slideUp(400);
        } else {
            e.addClass('open');
            e.children('ul').slideDown(400);
            e.siblings('li').children('ul').slideUp(400);
            e.siblings('li').removeClass('open');
        }
    });

    /* ************** colorswitch */
    if ($('#colorswitch-option').length) {
        $('#colorswitch-option button').on('click', function () {
            $('#colorswitch-option ul').toggleClass('show');
        });
        $('#colorswitch-option ul li').on('click', function () {
            $('#colorswitch-option ul li').removeClass('active');
            $(this).addClass('active');
            var colorPath = $(this).attr('data-path');
            $('#colorswitch').attr('href', colorPath);
        });
    }

    /* ************** megamenu */

    $('.f-menu > li').hover(function () {
        $(this)
            .closest('.list-item')
            .find('.f-menu > li')
            .removeClass('active');
        $(this).addClass('active');
    });

    $('.list-item.list-item-has-children.position-static').hover(function () {
        $('.main-content').append('<div class="trasparent-background"></div>');
        setTimeout(function () {
            $('.trasparent-background').css('opacity', '1');
        }, 20);
    });

    $('.list-item.list-item-has-children.position-static').mouseleave(
        function () {
            $('.trasparent-background').remove();
        }
    );

    $(document).on('click', '.add-to-cart-single', function () {
        var btn = this;

        $.ajax({
            type: 'POST',
            url: $(btn).data('action'),
            data: {
                quantity: 1
            },
            success: function (data) {
                if (data.status == 'success') {
                    Swal.fire({
                        type: 'success',
                        title: 'با موفقیت اضافه شد',
                        text: 'محصول مورد نظر با موفقیت به سبد خرید شما اضافه شد برای رزرو محصول سفارش خود را نهایی کنید.',
                        confirmButtonText: 'باشه',
                        footer: '<h5><a href="/cart">مشاهده سبد خرید</a></h5>'
                    });

                    $('#cart-list-item').replaceWith(data.cart);
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'خطا',
                        text: data.message,
                        confirmButtonText: 'باشه',
                        footer: '<h5><a href="/cart">مشاهده سبد خرید</a></h5>'
                    });
                }
            },
            beforeSend: function (xhr) {
                xhr.setRequestHeader(
                    'X-CSRF-TOKEN',
                    $('meta[name="csrf-token"]').attr('content')
                );
                block(btn.closest('.cart'));
            },
            complete: function () {
                unblock(btn.closest('.cart'));
            }
        });
    });
});
