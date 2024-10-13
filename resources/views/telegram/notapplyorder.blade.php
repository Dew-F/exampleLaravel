@php
if (!function_exists('markdown_escape')) {
    function markdown_escape($text) {
    return str_replace([
        '_', '*', '`'], [
        '\_', '\*', '\`',
    ], $text);
    }
}
@endphp
Заказ №{{$order->id}}
Заказчик: {{markdown_escape($order->full_name)}}
Телефон: {{markdown_escape($order->telephone)}}
Почта: {{markdown_escape($order->email)}}
Всего товаров: {{$carts->sum('count')}}
Общая стоимость: {{$order->total}} руб.
Менеджер: {{$manager ? markdown_escape($manager->name) : "Любой"}}
Полная информация о заказе выслана по почте.
