<div class="filter">
    @if(isset($fcategories) && isset($fattributes) && isset($fattributevalues))
    <h2 class="title">ФИЛЬТРЫ</h2>
    <form id="filter-attributes" class="filter-attributes" method="GET" action="{{route('applyfilter')}}">
        @if (count($fcategories) > 0)
            <a class="filter-name">Категория</a>
            <div class="filter-block">
                @foreach ($fcategories as $category)
                    <input type="checkbox" id="{{$category->uid}}" class="filter-checkbox" value="{{$category->uid}}" name="categories[]"><label for="{{$category->uid}}" class="filter-button">{{$category->name}}</label>
                @endforeach
            </div>
        @endif

    </form>
    <button type="submit" for="filter-attributes" id="filter-apply" class="button greenGradient">Применить фильтры</button>
    <button id="filter-clear" class="button greyGradient">Сбросить</button>
    <h3 class="title">Продукция<br>по параметрам<br>заказчика</h3>
    <a href="/custom" class="button greyGradient">Оставить заявку</a>
    <a href="/callback" class="button greyGradient">Заказать звонок</a>
    @endif
</div>
