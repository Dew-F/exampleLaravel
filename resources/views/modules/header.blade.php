@section('header')
<header>
    <div class="wrapper">
        <div class="logoContainer">
    	    <a href="/"><div class="logo" style="background-image:url('{{asset('/storage/images/structure/logo.png')}}')"></div></a>
    	</div>

        <div class="navContainer">
            <div class="burger"><span></span><span></span><span></span></div>
            <div class="nav">
                <a href="/news">Новости</a>
                <a href="/articles">Статьи</a>
                <a href="/payments">Оплата</a>
                <a href="/delivery">Доставка</a>
                <a href="/contacts">Контакты</a>
                <a href="/about">О нас</a>
                @auth
                    <div class="entry">
                        {{ auth()->user()->name }}
                        <div class="userMenu">
                            <a href="">Заказы</a>
                            <a href="{{route('changepass.show')}}">Изменить пароль</a>
                            <a href="{{route('auth.logout')}}">Выход</a>
                        </div>
                    </div>
                @else
                    <a href="/login" class="entry">Вход</a>
                @endif
            </div>
        </div>
        <div class="cartContainer"><a href="/cart">Корзина <b id="cartcount">{{session('cartcount') ?? session(['cartcount' => 0])}}</b></a></div>
        <div class="phonesContainer">
            Тел: <a href="tel:88005558054">8 (1212) 1212-12-12</a>, <a href="tel:+121212">+7 (1212) 1212-12-12</a>
        </div>

        <div class="searchContainer">
	        <form id="search" method="get" action="/search">
	            <input type="text" form="search" name="search" value="{{$search ?? ''}}" method="get" action="{{ route('search') }}" class="searchInput" placeholder='Поиск, например "обложка для тетради"'>
	            <button type="submit" form="search" class="searchButton"  style="background-image:url('{{asset('/storage/images/structure/search.png')}}')">&nbsp;</button>
	        </form>
    	</div>
    </div>
</header>
