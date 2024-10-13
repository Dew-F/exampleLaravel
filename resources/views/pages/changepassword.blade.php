@extends('templates.base')

@section('title', 'Изменение пароля')
@section('keywords', '')
@section('description', 'Изменение пароля')
@section('directory', 'Изменение пароля')

@section('content')
    <div class="loginWrapper">
        <h1>Изменение пароля</h1><br/>
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
        <form id="pwdchng" method="post" action="{{route('auth.changepass')}}">
            @csrf
            <input type="password" name="password" form="pwdchng" placeholder="Новый пароль*" required><br>
            <input type="password" name="password_confirmation" form="pwdchng" placeholder="Новый пароль еще раз*" required><br><br>
            <div class="g-recaptcha recaptcha" data-sitekey="{{config('services.recaptcha.siteKey')}}"></div>
            <input type="hidden" name="action" form="pwdchng" value="pwdchng">
            <button type="submit" form="pwdchng" class="greenGradient">Изменить пароль</button>
        </form>
        <br> * поля, обязательные для заполнения
    </div>
@endsection

@push('scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endpush
