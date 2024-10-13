//Управление списком категории на главной странице, добавление функционала на кнопки на раскрытие категорий
$(() => {
    if ($('.index').length === 0) return;

    $('.catalog-list > li').on('click', function (event) {
        if ($(this).next().css('display') != 'block') {
            $('.catalog-list > li').each(function() {
                $(this).next().hide();
                $(this).removeClass('active');
                $(this).children('.expand').html('+');
            });
            $(this).addClass('active');
            $(this).children('.expand').html('-');
            $(this).next().show()
        } else {
            $(this).children('.expand').html('+');
            $(this).removeClass('active');
            $(this).next().hide();
        }
    });

    $('.catalog-expand-close').on('click', function (event) {
        $(this).parent().hide();
        $(this).parent().prev().removeClass('active');
        $(this).parent().prev().children('.expand').html('+');
    });
});
