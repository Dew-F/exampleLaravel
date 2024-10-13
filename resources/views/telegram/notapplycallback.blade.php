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
Запрос №{{$custom->id}}
Просит перезвонить: {{markdown_escape($custom->fullname)}}
Телефон: {{markdown_escape($custom->phone)}}
