@extends('templates.base')

@section('title', 'Заказ звонка')
@section('keywords', 'Заказать звонок')
@section('description', 'Заказать звонок')
@section('directory', 'Заказ звонка')

@section('content')
    <div class="loginWrapper">
        <h1>Заказ звонка</h1>
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
        <form id="callback" method="post" action="{{route('callback.send')}}">
            @csrf
            <input type="text" name="name" form="callback" placeholder="Как к вам обращаться?" value="" required><br>
            <input type="text" name="phone" form="callback" placeholder="Телефон" value="" required><br>
            <input type="hidden" name="action" form="callback" value="callback">
            <div class="g-recaptcha recaptcha" style="margin: 10px 0px" data-sitekey="{{config('services.recaptcha.siteKey')}}"></div>
            <div id="loginResult" class="redText"></div>
            <button type="submit" form="callback" class="greenGradient">Заказать звонок</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endpush
