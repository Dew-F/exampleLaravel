@extends('templates.base')

@section('title', 'Новости')
@section('keywords', 'новости')
@section('description', 'новости компании и отрасли')
@section('directory', 'Новости')

@section('content')
    <h1>Новости</h1>
    @foreach ($news as $new)
    <div class="posts-container">
        <a class="posts-text" href="/news/{{$new->id}}">{{$new->title}}</a>
        <div class="posts-date">{{$new->date->isoFormat('D MMMM Y')}}</div>
    </div>
    @endforeach
@endsection
