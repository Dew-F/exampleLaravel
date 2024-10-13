<div class="owl-carousel owl-theme carousel">
    @foreach ($carouselProducts as $product)
        <a href="{{$product->route}}" class="carousel-product" tabindex="-1">
            <img src="{{ $product->photo() }}" loading="lazy" class="carousel-image"/>
            <div class="carousel-name">{{$product->name}}</div>
            <div class="carousel-price">
                {{$product->retailPrice()}} руб.
            </div>
        </a>
    @endforeach
</div>
