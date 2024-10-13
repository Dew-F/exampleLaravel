@extends('templates.base')

@section('title', 'Вход в личный кабинет')
@section('keywords', 'Личный кабинет')
@section('description', 'Войти или зарегистрироваться')
@section('directory', 'Вход')

@section('content')
    <div class="loginWrapper">
    <h1>Вход</h1>
    @if ($message = Session::get('success'))
    	<span class="greenText">{{ $message }}</span>
    @endif
    @if ($errors->any())
    <span class="redText">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </span><br>
    @endif
    <form id="login" method="post" action="{{route('auth.login')}}">
    @csrf
    <input type="text" name="email" form="login" placeholder="Электронная почта" value="{{old('email') ?? ''}}" required><br>
    <input type="password" name="password" form="login" placeholder="Пароль" required><br>
    <input type="hidden" name="action" form="login" value="login">
    <button type="submit" form="login" class="greenGradient">Войти</button>
    </form>
    <a href="/registration">Зарегистрироваться</a><br>
    <a href="/forget">Забыли пароль?</a><br>
    </div>
@endsection
