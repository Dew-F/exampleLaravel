<div class="product-cell">
    <a href="{{$product->route}}">
        <img src="
                    {{ count(glob(public_path().'/storage/images/'.$product->uid.'*-1.*')) > 0 ? asset('/storage/images/'.basename(glob(public_path().'/storage/images/'.$product->uid.'*-1.*')[0])) : asset('/storage/images/structure/nophoto.png') }}
                "
            loading="lazy"  class="product-cell-image"></a>
    <a href="{{$product->route}}" class="product-cell-name">{{$product->name}}</a>
    <table>
        @if ($categorytype == 1)
            <tr>
                <td><b>Ваша цена: </b></td>
                <td><b class="product-cell-price">
                        {{$product->getPrice() != 0 ? number_format($product->getPrice(), 2, '.', '') : 'нет'}}
                </b></td>
            </tr>
            <tr>
                <td>Розничная: </td>
                <td>{{$product->retailPrice() != 0 ? number_format($product->retailPrice(), 2, '.', '')  : 'нет'}}</td>
            </tr>
            <tr>
                <td>Со скидкой: </td>
                <td>
                    @auth
                        {{$product->smallWholesalePrice() != 0 ? number_format($product->smallWholesalePrice(), 2, '.', '')  : 'нет'}}
                    @else
                        <a href="{{route('login.show')}}"> войти</a>
                    @endauth
                </td>
            </tr>
            <tr>
                <td>Оптовая: </td>
                <td>
                    @auth
                        {{$product->wholesalePrice() != 0 ? number_format($product->wholesalePrice(), 2, '.', '')  : 'нет'}}
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
    <span class="product-cell-article">Арт.: {{$product->article}}</span>
    @if($categorytype == 1)
        <div class="product-control" data-incart="{{(isset($cart) && count($cart->where('product_uid', $product->uid)) > 0 ) ? 1 : 0;}}" data-product_uid="{{$product->uid}}">
                <div class="product-counter">
                    <button class="product-count product-counter-dec">-</button>
                    <input class="product-count product-counter-input" type="text" value="{{isset($cart) ? $cart->where('product_uid', $product->uid)->first()->count ?? 1 : 1}}" min="1" autocomplete="off">
                    <button class="product-count product-counter-inc">+</button>
                </div>
                <button class="product-control-addtocart greenGradient">Купить</button>
        </div>
    @else
        <a href="{{$product->route}}" style="height: 25px; margin-top: 5px; grid-row:5" class="greenGradient">Заказать</a>
    @endif
    <span class="product-cell-other">
        @if($categorytype == 1)
            Цена указана в рублях с НДС<br>
        @endif
        {{$product->availability}}
    </span>
</div>
