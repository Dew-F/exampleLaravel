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
Запрос на индивидуальный заказ.
Номер запроса: {{$custom->id}}
Имя: {{markdown_escape($custom->fullname)}}
Телефон: {{markdown_escape($custom->phone)}}
Почта: {{markdown_escape($custom->email)}}

Дата и время: {{$custom->date}}
Образец (артикул): {{$custom->product ? markdown_escape($custom->product->article) : 'нет'}}
{{markdown_escape($custom->text)}}
