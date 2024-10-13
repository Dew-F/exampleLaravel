@extends('templates.base')

@section('content')
    <div class="index">
        @include('modules.carousel')
        <div class="index-other">
            @include('modules.filter')
            <div class="catalog">
                <div class="catalog-block">
                    <span class="catalog-title">КАТАЛОГ ТОВАРОВ</span>
                    @foreach($productCategory as $category)
                        <ul class="catalog-list">
                            <li><a>{{$category->name}} ({{count($category->products())}})</a><span class="expand">+</span></li>
                            <div class="catalog-expand-block">
                                <span class="catalog-expand-close">×</span>
                                {{$home->CategoryTree($category)}}
                            </div>
                        </ul>
                    @endforeach
                </div>
                <div class="catalog-block">
                    <span class="catalog-title">КАТАЛОГ УСЛУГ</span>
                    @foreach($serviceCategory as $category)
                        <ul class="catalog-list">
                            <li><a>{{$category->name}} ({{count($category->products())}})</a><span class="expand">+</span></li>
                            <div class="catalog-expand-block">
                                <span class="catalog-expand-close">×</span>
                                {{$home->CategoryTree($category)}}
                            </div>
                        </ul>
                    @endforeach
                </div>
                <div class="catalog-block">
                    <span class="catalog-title">КАТАЛОГ ПРОДУКЦИИ ПО ПАРАМЕТРАМ</span>
                    @foreach($customCategory as $category)
                        <ul class="catalog-list">
                            <li><a>{{$category->name}} ({{count($category->products())}})</a><span class="expand">+</span></li>
                            <div class="catalog-expand-block">
                                <span class="catalog-expand-close">×</span>
                                {{$home->CategoryTree($category)}}
                            </div>
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
