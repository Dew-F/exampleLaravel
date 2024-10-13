@section('main')
<main>
    <div class="directory">
        @if (explode('/', $_SERVER['REQUEST_URI'])[1] != '')
        <a href="/">Главная</a> /
            @if (explode('/', $_SERVER['REQUEST_URI'])[1] == 'product')
                @foreach ($categories as $category)
                    <a href="{{$category->route}}">{{$category->name}}</a> /
                @endforeach
            @elseif (explode('/', $_SERVER['REQUEST_URI'])[1] == 'category')
                @foreach ($categories as $category)
                    <a href="{{$category->route}}">{{$category->name}}</a> /
                @endforeach
                @yield('directory')
            @elseif (explode('/', $_SERVER['REQUEST_URI'])[1] == 'news' && count(explode('/', $_SERVER['REQUEST_URI'])) > 2)
                <a href="{{route('news.show')}}">Новости</a>
            @elseif (explode('/', $_SERVER['REQUEST_URI'])[1] == 'articles' && count(explode('/', $_SERVER['REQUEST_URI'])) > 2)
                <a href="{{route('articles.show')}}">Статьи</a>
            @else
                @yield('directory')
            @endif
        @endif
    </div>
    <div class="content">
        @yield('content')
    </div>
</main>
