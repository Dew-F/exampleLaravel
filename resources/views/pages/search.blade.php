@extends('templates.base')

@section('title', 'Поиск')
@section('keywords', 'Поиск товаров')
@section('description', 'Поиск')
@section('directory', 'Поиск')

@section('content')
    <h1>Поиск</h1>
    <h2>"{{$search}}"</h2>
    @if (count($categories) > 0)
    <h2>Категории ({{ count($categories) }})</h2>
    @foreach ($categories as $category)
        <a href="{{$category->route}}">{{$category->name}}</a><br>
    @endforeach
    @endif
    @if (count($products) > 0)
    <h2>Товары ({{ count($products) }})</h2>
    @foreach ($products as $product)
        <a href="{{$product->route}}">{{$product->name}}</a><br>
    @endforeach
    @endif
@endsection
