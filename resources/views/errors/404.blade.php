@extends('templates.base')

@section('title', 'Страница не найдена')

@section('content')
    <h1>Страница не найдена</h1>
    <a href="{{route('home')}}">Вернуться на главную</a>
@endsection
