(function () {
    function removeWholesaleTopText() {
        var targetTexts = [
            'پخش عمده تأمین مستقیم لوازم جانبی موبایل برای فروشگاه‌ها',
            'پخش عمده تأمین مستقیم لوازم جانبی موبایل برای فروشگاه‌ه'
        ];

        var selectors = ['.wholesale-top-strip', '.wholesale-top-strip__content', '.wholesale-badge'];
        selectors.forEach(function (selector) {
            document.querySelectorAll(selector).forEach(function (el) {
                el.remove();
            });
        });

        document.querySelectorAll('body *').forEach(function (el) {
            if (!el || !el.textContent) return;

            var normalized = el.textContent.replace(/\s+/g, ' ').trim();
            var hasText = targetTexts.some(function (txt) {
                return normalized.indexOf(txt) !== -1;
            });

            if (!hasText) return;

            var removableContainer = el.closest('header, .topbar, .main-header, .container, .dt-sl, div');
            if (removableContainer) {
                removableContainer.remove();
            } else {
                el.remove();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', removeWholesaleTopText);
    } else {
        removeWholesaleTopText();
    }
})();
