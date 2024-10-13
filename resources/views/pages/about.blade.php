@extends('templates.base')

@section('title', 'О компании')
@section('keywords', 'О компании')
@section('description', 'Информация о компании')
@section('directory', 'О компании')

@section('content')
    <h1>О компании</h1>
    <div class="about-container">
        <div class="tabs"><div class="tab">О компании</div></div>
        <div class="about-text">
            loram ispum lo rum loram ispum lo rum loram ispum lo rum loram ispum lo rum loram ispum lo rum loram ispum lo rum
            loram ispum lo rum loram ispum lo rum loram ispum lo rum loram ispum lo rum loram ispum lo rum loram ispum lo rum
            loram ispum lo rum loram ispum lo rum loram ispum lo rum loram ispum lo rum loram ispum lo rum loram ispum lo rum
            loram ispum lo rum loram ispum lo rum loram ispum lo rum loram ispum lo rum loram ispum lo rum loram ispum lo rum

            Наши менеджеры:<br>
            @foreach ($managers as $manager)
                <div class="about-manager">
                    <img class="about-manager-image" src="@if (file_exists(public_path('/storage/images/managers/'.$manager->id.'.jpg'))) {{asset('/storage/images/managers/'.$manager->id.'.jpg')}} @else {{asset('/storage/images/structure/noavatar.png')}} @endif">
                    <div class="about-manager-text">
                        <span class="about-manager-name">{{$manager->name}}</span><br>
                        <a href="tel:{{$manager->phone}}">{{sprintf("%s (%s) %s-%s-%s",
                                                            substr($manager->phone, 0, 1),
                                                            substr($manager->phone, 1, 3),
                                                            substr($manager->phone, 4, 3),
                                                            substr($manager->phone, 7, 2),
                                                            substr($manager->phone, 9))}}</a><br>
                        <a href="mailto:{{$manager->mail}}">{{$manager->mail}}</a>
                    </div>
                </div>
            @endforeach
            <br>
            Адрес: <span itemprop="address">loram ispum lo rum loram ispum lo rum loram ispum lo rum loram ispum lo rum loram ispum lo rum </span><br>

            <div class="map">
                <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%12121212121212&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
            </div>
        </div>
    </div>
@endsection
