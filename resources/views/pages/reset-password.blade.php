@extends('templates.base')

@section('title', 'Сброс пароля')
@section('keywords', '')
@section('description', 'Сброс пароля')
@section('directory', 'Сброс пароля')

@section('content')
    <div class="loginWrapper">
        <h1>Сброс пароля</h1><br/>
        @if ($errors->any())
    	<span class="redText">
	        @foreach ($errors->all() as $error)
	            <li>{{ $error }}</li>
	        @endforeach
        </span><br>
        @endif
        @if ($message = Session::get('success'))
    	    <span class="greenText">{{ $message }} {{Session::get('status')}}</span>
        @endif
        <form id="password-restore" method="post" action="{{route('password.update')}}">
            @csrf
            <input type="text" name="email" form="password-restore" placeholder="Электронная почта*" required><br>
            <input type="password" name="password" form="password-restore" placeholder="Новый пароль*" required><br>
            <input type="password" name="password_confirmation" form="password-restore" placeholder="Новый пароль еще раз*" required><br><br>
            <div class="g-recaptcha recaptcha" data-sitekey="{{config('services.recaptcha.siteKey')}}"></div>
            <input type="hidden" name="token" form="password-restore" value="{{$token}}">
            <button type="submit" form="password-restore" class="greenGradient">Изменить пароль</button>
        </form>
        <br> * поля, обязательные для заполнения
    </div>
@endsection

@push('scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endpush
