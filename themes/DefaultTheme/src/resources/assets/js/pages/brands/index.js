$(document).ready(function () {
    const brandSearchInput = $('#brand-search');
    const brands = $('.single-brand-div');

    brandSearchInput.on('input', function () {
        const searchTerm = $(this).val().trim().toLowerCase();

        brands.each(function () {
            const brandName = $(this)
                .find('.product-title')
                .text()
                .toLowerCase();
            if (brandName.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
