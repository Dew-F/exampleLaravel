@extends('templates.base')

@section('content')
    <div class="category">
        @include('modules.filter')
        <div class="category-container">
            <h1>
                {{$category->name ?? "Поиск по фильтру"}}
            </h1>
            @if ($categorytype == 1)
            <div class="tabs">
                <div class="tab active"><a href="{{route('production')}}">Продукция</a></div>
                <div class="tab"><a href='{{route('custom')}}'>Продукция<br>по параметрам<br>заказчика</a></div>
            </div>
            @endif
            <div class="info">Всего @if($categorytype == 1) товаров: @else услуг: @endif {{$products->total()}} <b></b></div>
            <div class="tab-container">
                @foreach ($products as $product)
                    @include('modules.productcell')
                @endforeach
            </div>
            <div>{{ $products->links() }}</div>
            @if (isset($category) && $category->category_footer_title)
                <div class="category-footer">
                    <div>{!! $category->category_footer_title !!}</div>
                    @if ($category->category_footer_text)
                        <button id="category-footer-button" class="greyGradient">Узнать подробности</button>
                        <div id="category-footer-text">{!! $category->category_footer_text !!}</div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
