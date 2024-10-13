@extends('templates.base')

@section('title',  $product->name)

@push('styles')
@endpush

@section('content')
    <div class="product">
        <div class="product-block">
            <div class="image-block">
                <div class="fotorama" data-ratio="4/3" data-nav="thumbs" style="transition: none;" data-allowfullscreen="true" data-height="400px" data-width="100%"
                data-maxheight="400px" >
                    @if (count(glob(public_path().'/storage/images/'.$product->uid.'*')) > 0) {
                        <img src="{{asset('/storage/images/'.basename(glob(public_path().'/storage/images/'.$product->uid.'*-1.*')[0]))}}">
                        @foreach(glob(public_path().'/storage/images/'.$product->uid.'*') as $photo)
                            @if (glob(public_path().'/storage/images/'.$product->uid.'*-1.*')[0] != $photo)
                                <img src="{{asset('/storage/images/'.basename($photo))}}">
                            @endif
                        @endforeach
                    @else
                        <img src="{{asset('/storage/images/structure/nophoto.png')}}">
                    @endif
                    @foreach(explode(';', $product->video) as $video)
                        @if ($video != '')
                        <a href="https://www.youtube.com/watch?v={{$video}}"></a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="product-info">
                <h1 class="product-name">{{$product->name}}</h1>
                <div class="product-description">
                    {!!$product->description!!}
                </div>
                @if ($productAttributes->count() > 0)
                <div class="product-attributes">
                    <h2>Характеристики:</h2>
                    <ul>
                        @foreach ($productAttributes as $attribute)
                            <li>{{$attributeValues->where('uid', $attribute->attribute_value_uid)->first()->name}}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="product-article">Артикул: <b>{{$product->article}}</b></div>
                <table class="product-price">
                    <table>
                        @if ($categorytype == 1)
                            <tr>
                                <td><b>Ваша цена: </b></td>
                                <td><b class="product-cell-price">
                                    {{$product->getPrice()}}
                                </b></td>
                            </tr>
                            <tr>
                                <td>Розничная: </td>
                                <td>{{$product->retailPrice() != 0 ? number_format($product->retailPrice(), 2, '.', '') : 'нет'}}</td>
                            </tr>
                            <tr>
                                <td>Со скидкой: </td>
                                <td>
                                    @auth
                                        {{$product->smallWholesalePrice() != 0 ? number_format($product->smallWholesalePrice(), 2, '.', '') : 'нет'}}
                                    @else
                                        <a href="{{route('login.show')}}"> войти</a>
                                    @endauth
                                </td>
                            </tr>
                            <tr>
                                <td>Оптовая: </td>
                                <td>
                                    @auth
                                        {{$product->wholesalePrice() != 0 ? number_format($product->wholesalePrice(), 2, '.', '') : 'нет'}}
                                    @else
                                        <a href="{{route('login.show')}}"> войти</a>
                                    @endauth
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td><b>Цена:</b></td>
                                <td>Зависит от техзадания</td>
                            </tr>
                        @endif
                    </table>
                @if($categorytype == 1)
                    <div class="product-price-description">
                        Цена указана в рублях с НДС<br>
                        {{$product->availability}}
                    </div>
                    <div class="product-control" data-incart="{{(isset($cart) && count($cart->where('product_uid', $product->uid)->get()) > 0 ) ? 1 : 0;}}" data-product_uid="{{$product->uid}}">
                        <div class="product-counter">
                            <button class="product-count product-counter-dec">-</button>
                            <input class="product-count product-counter-input" type="text" value="{{isset($cart) ? $cart->where('product_uid', $product->uid)->first()->count ?? 1 : 1}}" min="1" autocomplete="off">
                            <button class="product-count product-counter-inc">+</button>
                        </div>
                        <button class="product-control-addtocart greenGradient">Купить</button>
                        <button class="product-control-print greyGradient" onclick="window.print();">Печать</button>
                    </div>
                @endif
            </div>
        </div>
        @if($categorytype != 1)
            <div>
                <form id="custom" method="post" action="{{route('custom.send')}}">
                    @csrf
                    <input type="text" form="custom" name="name" placeholder="ФИО" value="{{old('name') ?? ''}}" required><br>
                    <input type="text" form="custom" name="phone" placeholder="Телефон для связи" value="{{old('phone') ?? ''}}" required><br>
                    <input type="text" form="custom" name="email" placeholder="E-mail для связи" value="{{old('email') ?? ''}}" required><br>
                    <textarea form="custom" name="description" placeholder="Описание заказа" required>{{old('description') ?? ''}}</textarea><br>
                    <input type="hidden" form="custom" name="sample" value="{{$product->uid}}">
                    <div style="justify-content:start;" class="g-recaptcha recaptcha" data-sitekey="{{config('services.recaptcha.siteKey')}}"></div>
                    <button type="submit" form="custom" class="greenGradient">Оставить заказ</button>
                </form>
                <br>
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
            </div>
        @endif
        <div class="product-other">
            @include('modules.carousel')
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endpush
