$(() => {
    if ($('.category').length === 0) return;

    $('#category-footer-button').on('click', function() {
        $('#category-footer-text').slideToggle();
    });
});
