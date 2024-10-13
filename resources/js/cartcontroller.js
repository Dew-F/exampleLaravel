$(() => {
    //Управление товарами в корзине
    if ($('.product-control').length === 0) return;
    $('.cart-button-clear').first().on('click', () => clearCart());
    $('.product-control').each(function () {
        let element_count = $('.product-counter-input', this).first();
        let product_uid = $(this).data('product_uid');
        let element_addtocart = $('.product-control-addtocart', this).first();
        let function_addtocart = () => addToCart(product_uid, this, function_addtocart, function_deltocart, function_updtocart);
        let function_deltocart = () => delToCart(product_uid, this, function_addtocart, function_deltocart, function_updtocart);
        let function_updtocart = () => updateToCart(product_uid, element_count.val(), this);
        if ($(this).data('incart')) {
            //Стандартно
            if ($('.product-cart-delete').length === 0) {
                element_addtocart.html('В корзине!');
                element_addtocart.on('click', function_deltocart);
                element_count.on('change', function_updtocart);
            }
            //Если в корзине
            else {
                element_addtocart.html('Удалить');
                element_addtocart.on('click', function_deltocart);
                element_count.on('change', function_updtocart);
            }
        } else {
            element_addtocart.on('click', function_addtocart)
        }
    });

    //Оформление заказа
    //Кнопка оформить
    $('#cart-button-order').on('click', function() {
        $('#cart-form-order').slideToggle();
    });

    //Выбор сотрудника-менеджера
    $('.cart-manager').on('click', function() {
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $('#selected-manager').val('');
        } else {
            $('.cart-manager').each(function() {
                $(this).removeClass('active');
            });
            $(this).addClass('active');
            $('#selected-manager').val($(this).data('id'));
        }
    });
});

//Выключение кнопок управления
function controlOff(element){
    let element_addtocart = $('.product-control-addtocart', element).first();
    let element_count = $('.product-counter-input', element).first();
    element_addtocart.prop('disabled', true);
    element_count.prop('disabled', true);
    element_count.prev().prop('disabled', true);
    element_count.next().prop('disabled', true);
}

//Включение кнопок управления
function controlOn(element){
    let element_addtocart = $('.product-control-addtocart', element).first();
    let element_count = $('.product-counter-input', element).first();
    element_addtocart.prop('disabled', false);
    element_count.prop('disabled', false);
    element_count.prev().prop('disabled', false);
    element_count.next().prop('disabled', false);
}

//Добавить в корзину
function addToCart(product_uid, elements, function_addtocart, function_deltocart, function_updtocart) {
    let element = $('.product-control-addtocart', elements).first();
    let element_count = $('.product-counter-input', elements).first();
    controlOff(elements);
    fetch(`/cart/add`, {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
        body: JSON.stringify({
            'product_uid' : product_uid,
            'count': element_count.val()
        })
    })
    .then(response => response.json())
    .then(data => {
        element.html('В корзине!');
        element.off('click', function_addtocart);
        element.on('click', function_deltocart);
        element_count.on('change', function_updtocart);
        $('#cartcount').html(Number($('#cartcount').html()) + 1)
        controlOn(elements);
    })
    .catch(error => {
        //console.error('Ошибка при добавлении товара в корзину:', error);
    });
}

//Удалить из корзины
function delToCart(product_uid, elements, function_addtocart, function_deltocart, function_updtocart) {
    let element = $('.product-control-addtocart', elements).first();
    let element_count = $('.product-cart-delete').length === 0 ?
                        $('.product-counter-input', elements).first() :
                        $(elements).parent().parent().find('.product-counter-input');
    controlOff(elements);
    fetch(`/cart/del`, {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({'product_uid' : product_uid })
    })
    .then(response => response.json())
    .then(data => {
        element.html('Купить');
        element.off('click', function_deltocart);
        element.on('click', function_addtocart);
        element_count.off('change', function_updtocart);
        $('#cartcount').html(Number($('#cartcount').html()) - 1)

        //Если в корзине
        if ($('.product-cart-delete').length !== 0) {
            $('#cart-count').html(Number($('#cart-count').html()) - Number(element_count.val()));
            $('#cart-sum').html(Number((Number($('#cart-sum').html()) - Number(element_count.val()) * Number($(elements).parent().parent().find('.product-cart-price-sum').html())).toFixed(2)));
            $(elements).parent().parent().parent().remove();
        }

        controlOn(elements);
    })
    .catch(error => {
        //console.error('Ошибка при удаление товара из корзины:', error);
    });
}

//Обновить значение в корзине
function updateToCart(product_uid, count, elements) {
    controlOff(elements);
    fetch(`/cart/update`, {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            'product_uid' : product_uid,
            'count': count
        })
    })
    .then(response => response.json())
    .then(data => {
        //Если в корзине
        if ($('.product-cart-delete').length !== 0) {
            $('#cart-count').html(Number($('#cart-count').html()) + Number(data.countedit));
            $('#cart-sum').html(Number(data.count * data.price).toFixed(2));
        }
        let prevsum = data.sum - Number(data.countedit) * Number(data.retail_price);
        if (prevsum >= 60000 && data.sum < 60000) {
            location.reload();
        } else if ((prevsum >= 30000 && data.sum < 30000) || (prevsum >= 30000 && prevsum < 60000 && data.sum >= 60000)) {
            location.reload();
        } else if (prevsum < 30000 && data.sum >= 30000) {
            location.reload();
        }
        controlOn(elements);
    })
    .catch(error => {
        console.error('Ошибка при изменение товара в корзине:', error);
    });
}

//Очистить корзину
function clearCart() {
    fetch(`/cart/clear`, {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(() => {
        $('.cart').html('Корзина пуста');
        $('#cartcount').html(0)
    })
    .catch(error => {
        //console.error('Ошибка при очистке коризны:', error);
    });
}
