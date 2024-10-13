@extends('templates.base')

@section('content')
    <div class="category">
    @include('modules.filter')
    <div class="category-container">
        <div class="tabs">
            <div class="tab active">Продукция</div>
            <div class="tab"><a href='{{route('custom')}}'>Продукция<br>по параметрам</a></div>
        </div>
        <div class="production tab-container">
            @foreach($productCategory as $category)
                <ul class="catalog-list">
                    <li>
                        <a href="{{$category->route}}">{{$category->name}}</a>
                        {{$home->CategoryTree($category)}}
                </ul>
            @endforeach
        </div>
    </div>
    </div>
@endsection
