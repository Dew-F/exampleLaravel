Заказчик: {{$data['order']->full_name}}<br>
Номер заказа: {{$data['order']->id}}<br>
Телефон: {{$data['order']->telephone}}<br>
Почта: {{$data['order']->email}}<br>
Менеджер: {{$data['manager'] ? $data['manager']->name : "Любой"}}<br>
Состав заказа:
<ul>
    @foreach ($data['carts'] as $cart)
        <li>{{$cart->product->name}} {{$cart->product->article}} ({{$cart->product->getPriceByType($data['priceType'])}} руб.): {{$cart->count}};</li>
    @endforeach
</ul>
<br>Всего товаров: {{$data['carts']->sum('count')}};
<br>Общая стоимость: {{$data['sum']}} руб.
