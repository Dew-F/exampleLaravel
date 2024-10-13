@extends('templates.base')

@section('title', 'Заказ')
@section('keywords', 'Заказ')
@section('description', 'Заказ')
@section('directory', 'Заказ')

@section('content')
    <div class="order-complete">
        <span class="text">
            @if ($message = Session::get('text'))
                {!! $message !!}
            @endif
            @if($text && $text != "")
            {!!$text!!}
            @endif
        </span>
        <a href="/" class="greenGradient">Вернуться на главную</a>
    </div>
@endsection
