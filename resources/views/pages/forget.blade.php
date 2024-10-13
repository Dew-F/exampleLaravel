@extends('templates.base')

@section('title', 'Восстановление пароля')
@section('keywords', '')
@section('description', 'Восстановление пароля')
@section('directory', 'Восстановление пароля')

@section('content')
    <div class="loginWrapper">
        <h1>Восстановление пароля</h1><br/>
        @if ($errors->any())
    	<span class="redText">
	        @foreach ($errors->all() as $error)
	            <li>{{ $error }}</li>
	        @endforeach
        </span><br>
        @endif
        @if ($message = Session::get('success'))
    	    <span class="greenText">{{ $message }}</span>
        @endif
        <form id="password-request" method="post" action="{{route('password.email')}}">
            @csrf
            <input type="text" name="email" form="password-request" placeholder="Электронная почта*" required><br>
            <div class="g-recaptcha recaptcha" data-sitekey="{{config('services.recaptcha.siteKey')}}" style="margin-top:5px"></div>
            <button type="submit" form="password-request" class="greenGradient">Восстановить пароль</button>
        </form>
        <br> * поля, обязательные для заполнения
    </div>
@endsection

@push('scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endpush
