$(document).ready(function () {
    const sectionsWrapper = $('#sections-wrapper');
    const quickLinksWrapper = $('#quick-links-wrapper');

    function rebuildSectionNames() {
        sectionsWrapper.find('.section-row').each(function (index) {
            const row = $(this);
            row.find('.section-type').attr('name', 'sections[' + index + '][type]');
            row.find('.section-title').attr('name', 'sections[' + index + '][title]');
            row.find('.section-sort').attr('name', 'sections[' + index + '][sort_order]');

            const checkbox = row.find('.section-enabled');
            const checkboxId = 'section_enabled_' + index;
            checkbox.attr('name', 'sections[' + index + '][enabled]');
            checkbox.attr('id', checkboxId);
            row.find('label[for^="section_enabled_"]').attr('for', checkboxId);
        });
    }

    function rebuildQuickLinkNames() {
        quickLinksWrapper.find('.quick-link-row').each(function (index) {
            const row = $(this);
            row.find('.quick-link-label').attr('name', 'quick_links[' + index + '][label]');
            row.find('.quick-link-url').attr('name', 'quick_links[' + index + '][url]');
            row.find('.quick-link-sort').attr('name', 'quick_links[' + index + '][sort_order]');

            const checkbox = row.find('.quick-link-enabled');
            const checkboxId = 'quick_link_enabled_' + index;
            checkbox.attr('name', 'quick_links[' + index + '][enabled]');
            checkbox.attr('id', checkboxId);
            row.find('label[for^="quick_link_enabled_"]').attr('for', checkboxId);
        });
    }

    function addSectionRow(data) {
        const template = $($('#section-row-template').html());
        template.find('.section-type').val(data.type || 'quick_links');
        template.find('.section-title').val(data.title || '');
        template.find('.section-sort').val(data.sort_order || sectionsWrapper.children().length + 1);
        template.find('.section-enabled').prop('checked', data.enabled !== false);
        sectionsWrapper.append(template);
        rebuildSectionNames();
    }

    function addQuickLinkRow(data) {
        if (quickLinksWrapper.find('.quick-link-row').length >= 4) {
            Swal.fire({
                type: 'warning',
                title: 'حداکثر ۴ لینک قابل ثبت است',
                confirmButtonClass: 'btn btn-primary',
                confirmButtonText: 'باشه',
                buttonsStyling: false,
            });
            return;
        }

        const template = $($('#quick-link-row-template').html());
        template.find('.quick-link-label').val(data.label || '');
        template.find('.quick-link-url').val(data.url || '');
        template.find('.quick-link-sort').val(data.sort_order || quickLinksWrapper.children().length + 1);
        template.find('.quick-link-enabled').prop('checked', data.enabled !== false);
        quickLinksWrapper.append(template);
        rebuildQuickLinkNames();
    }

    function bindMoveAndRemove() {
        $(document).on('click', '.remove-section', function () {
            $(this).closest('.section-row').remove();
            rebuildSectionNames();
        });

        $(document).on('click', '.remove-quick-link', function () {
            $(this).closest('.quick-link-row').remove();
            rebuildQuickLinkNames();
        });

        $(document).on('click', '.section-row .move-up, .quick-link-row .move-up', function () {
            const row = $(this).closest('.section-row, .quick-link-row');
            row.prev().before(row);
            rebuildSectionNames();
            rebuildQuickLinkNames();
        });

        $(document).on('click', '.section-row .move-down, .quick-link-row .move-down', function () {
            const row = $(this).closest('.section-row, .quick-link-row');
            row.next().after(row);
            rebuildSectionNames();
            rebuildQuickLinkNames();
        });
    }

    $('#add-section').on('click', function () {
        addSectionRow({});
    });

    $('#add-quick-link').on('click', function () {
        addQuickLinkRow({});
    });

    $('#reset-footer').on('click', function () {
        const resetUrl = $(this).data('action');

        Swal.fire({
            title: 'بازنشانی انجام شود؟',
            text: 'تنظیمات فوتر به حالت پیش‌فرض برمی‌گردد.',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'بله',
            cancelButtonText: 'خیر',
            confirmButtonClass: 'btn btn-danger',
            cancelButtonClass: 'btn btn-outline-secondary',
            buttonsStyling: false,
        }).then(function (result) {
            if (!result.value) {
                return;
            }

            $.ajax({
                url: resetUrl,
                type: 'POST',
                beforeSend: function (xhr) {
                    block('#footer-main-card');
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function () {
                    window.location.reload();
                },
                complete: function () {
                    unblock('#footer-main-card');
                },
            });
        });
    });

    $('#footer-form').submit(function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function () {
                Swal.fire({
                    type: 'success',
                    title: 'تنظیمات فوتر ذخیره شد',
                    confirmButtonClass: 'btn btn-primary',
                    confirmButtonText: 'باشه',
                    buttonsStyling: false,
                });
            },
            error: function (xhr) {
                const message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'خطا در ذخیره تنظیمات';
                Swal.fire({
                    type: 'error',
                    title: message,
                    confirmButtonClass: 'btn btn-primary',
                    confirmButtonText: 'باشه',
                    buttonsStyling: false,
                });
            },
            beforeSend: function (xhr) {
                block('#footer-main-card');
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            complete: function () {
                unblock('#footer-main-card');
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    });

    bindMoveAndRemove();

    (window.footerInitialData.sections || []).forEach(function (section) {
        addSectionRow(section);
    });

    (window.footerInitialData.quickLinks || []).forEach(function (link) {
        addQuickLinkRow(link);
    });

    if (sectionsWrapper.find('.section-row').length === 0) {
        addSectionRow({ type: 'quick_links', title: 'دسترسی سریع', sort_order: 1, enabled: true });
    }
});
