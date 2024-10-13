Здраствуйте, {{$data['order']->full_name}}<br><br>
Номер вашего заказа: {{$data['order']->id}}<br>
Состав заказа:
<ul>
@foreach ($data['carts'] as $cart)
    <li>{{$cart->product->name}} {{$cart->product->article}} ({{$cart->product->getPriceByType($data['priceType'])}} руб.): {{$cart->count}};</li>
@endforeach
</ul>
<br>Всего товаров: {{$data['carts']->sum('count')}};
<br>Общая стоимость: {{$data['sum']}} руб.
<br>В ближайшее время с вами свяжется менеджер.
<br><br>Спасибо за ваш заказ!
