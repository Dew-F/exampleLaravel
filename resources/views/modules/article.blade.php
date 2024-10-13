@extends('templates.base')

@section('title',  $article->title)

@section('content')
<div class="post">
    <h2>{{$article->title}}</h2>
    <span class="date">{{$article->date}}</span>
    <div>
        {!!$article->text!!}
    </div>
</div>
@endsection
