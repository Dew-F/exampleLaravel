<div class="product-cart">
    <div class="product-cart-info">
        <img class="product-cart-image" src="
                                            {{ count(glob(public_path().'/storage/images/'.$cart->product->uid.'*-1.*')) > 0 ? asset('/storage/images/'.basename(glob(public_path().'/storage/images/'.$cart->product->uid.'*-1.*')[0])) : asset('/storage/images/structure/nophoto.png') }}
        " >
        <div class="product-cart-name"><a href="{{$cart->product->route}}">{{$cart->product->name}}</a></div>
    </div>
    <div class="product-cart-control">
        <div class="product-cart-counter">
            <div class="product-control" data-incart="{{($cart != null && count($cart->where('product_uid', $cart->product->uid)->get()) > 0 ) ? 1 : 0;}}" data-product_uid="{{$cart->product->uid}}">
                <div class="product-counter">
                    <button class="product-count product-counter-dec">-</button>
                    <input class="product-count product-counter-input" type="text" value="{{$cart->getCart()->where('product_uid', $cart->product->uid)->first()->count}}" min="1" autocomplete="off">
                    <button class="product-count product-counter-inc">+</button>
                    &nbsp;шт.
                </div>
            </div>
        </div>
        <div class="product-cart-price"><span class="product-cart-price-sum">
            {{$cart->product->getPrice() != 0 ? $cart->product->getPrice().' руб/шт' : 'нет'}}
        </div>
        <div class="product-cart-delete">
            <div class="product-control" data-incart="{{($cart != null && count($cart->where('product_uid', $cart->product->uid)->get()) > 0 ) ? 1 : 0;}}" data-product_uid="{{$cart->product->uid}}">
                <button class="product-control-addtocart button">Удалить</button>
            </div>
        </div>
    </div>
</div>
