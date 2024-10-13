@extends('templates.base')

@section('title', 'Регистрация')
@section('keywords', 'Регистрация')
@section('description', 'Зарегистрироваться')
@section('directory', 'Регистрация')

@section('content')
    <div class="loginWrapper">
        <h1>Регистрация</h1>
        @if ($errors->any())
    	<span class="redText">
	        @foreach ($errors->all() as $error)
	            <li>{{ $error }}</li>
	        @endforeach
        </span><br>
        @endif
        <form id="register" method="post" action="{{route('registration.create') }}">
            @csrf
            <input type="text" name="email" form="register" value="{{old('email') ?? ''}}" placeholder="Электронная почта*" required><br>
            <input type="text" name="name" form="register" value="{{old('name') ?? ''}}" placeholder="ФИО*" required><br>
            <input type="text" name="phone" form="register" value="{{old('phone') ?? ''}}" placeholder="Телефон"><br>
            <input type="text" name="city" form="register" value="{{old('city') ?? ''}}" placeholder="Город*" required><br>
            <input type="text" name="address" form="register" value="{{old('address') ?? ''}}" placeholder="Адрес доставки"><br>
            <input type="password" name="password" form="register" placeholder="Пароль*" required><br>
            <input type="password" name="password_confirmation" form="register" placeholder="Пароль еще раз*" required><br>
            <input type="hidden" name="action" form="register" value="register">
            <button type="submit" form="register" class="greenGradient">Зарегистрироваться</button>
        </form>
        <br> * поля, обязательные для заполнения
        </div>
@endsection
