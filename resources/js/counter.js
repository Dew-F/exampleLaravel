//Управление количеством товара
$(() => {
    if ($('.product-control').length === 0) return;
    $('.product-counter-input').each(function() {
        $(this).prev().on('click', () => CountDec($(this)));
        $(this).next().on('click', () => CountInc($(this)));
        $(this).on('change', () => InputController($(this)));
    });
});

function CountInc(counter){
    let curCount = parseInt(counter.val());
    counter.val(curCount + 1);
    counter.change();
}

function CountDec(counter){
    let curCount = parseInt(counter.val());
    if (curCount > 1){
        counter.val(curCount - 1);
    }
    counter.change();
}

function InputController(counter) {
    if ((Number(counter.val()) != counter.val())) counter.val(1);
    if (counter.val() < 1) {
        counter.val(1);
    }
}
