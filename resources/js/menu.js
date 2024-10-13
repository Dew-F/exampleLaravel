//Менюшка-бургер
$(() => {
    $('.burger').on('click', function (){
        $('.nav').toggleClass('opened');
        $('.burger').toggleClass('opened');
    });
});
