@extends('templates.base')

@section('title',  $news->title)

@section('content')
<div class="post">
    <h2>{{$news->title}}</h2>
    <span class="date">{{$news->date}}</span>
    <div>
        {!!$news->text!!}
    </div>
</div>
@endsection
