@extends('templates.base')

@section('title', 'Корзина')
@section('keywords', 'Ваши товары в корзине')
@section('description', 'Ваши товары в корзине')
@section('directory', 'Корзина')

@section('content')
    <h1>Корзина</h1>
    @if (count($carts) > 0)
    <div class="cart">
        @foreach ($carts as $cart)
            @include('modules.productcart')
        @endforeach
        <div class="cart-other">
            <span>Всего товаров: <b id="cart-count">{{$carts->sum('count')}}</b> шт.</span>
            <span>Итого: <b id="cart-sum">{{$sum}}</b> руб.</span>
            <br>
            Вы можете оплатить заказ банковской картой на сайте.
            <img class="cart-payment-system" src="{{asset('/storage/images/structure/payment_systems.png')}}">
            <span class="cart-payment-online">Оплатить онлайн <input type="checkbox" form="cart-form-order" name="payonline" class="cart-payment-online-checker"></span>
            <div>
                <button class="cart-button cart-button-clear"> Очистить </button>
                <button id="cart-button-order" class="greenGradient cart-order-button">Оформить</button>
            </div>
        </div>
        <form id="cart-form-order" class="cart-form-order" method="POST" action="{{route('order.send')}}">
            @csrf
            <div class="cart-form-inputs">
                <input type="text" name="fullname" value="{{old('fullname') ?? Auth::user()->name ?? ""}}" placeholder="Ф.И.О.*" required>
                <input type="text" name="phone" value="{{old('phone') ?? Auth::user()->phone ?? ""}}" placeholder="Телефон*" required>
                <input type="text" name="email" value="{{old('email') ?? Auth::user()->email ?? ""}}" placeholder="Электронная почта" required>
            </div>
            <input type="hidden" id="selected-manager" name="manager" value="">
            <div class="cart-managers">
                <div class="cart-manager active" data-id="">
                    <img class="cart-manager-image" src="{{asset('/storage/images/structure/noavatar.png')}}">
                    <span class="cart-manager-name">Любой менеджер</span><br>
                </div>
                @foreach ($managers as $manager)
                    <div class="cart-manager" data-id="{{$manager->id}}">
                        <img class="cart-manager-image" src="@if (file_exists(public_path('/storage/images/managers/'.$manager->id.'.jpg'))) {{asset('/storage/images/managers/'.$manager->id.'.jpg')}} @else {{asset('/storage/images/structure/noavatar.png')}} @endif">
                        <span class="cart-manager-name">{{$manager->name}}</span><br>
                    </div>
                @endforeach
            </div>
            <div class="g-recaptcha recaptcha" style="margin: 10px 0px" data-sitekey="{{config('services.recaptcha.siteKey')}}"></div>
            <input type="submit" class="greenGradient cart-order-button" value="Завершить">
        </form>
            <span class="redText">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </span><br>
        @if ($message = Session::get('success'))
            <span class="greenText">{{ $message }}</span>
        @endif
    </div>
    @else
    Корзина пуста<br><br>
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
    @endif
@endsection

@push('scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endpush
