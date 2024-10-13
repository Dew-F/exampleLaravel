@if ($orders->count() > 0)
Заказы не принятые менеджерами:
    @foreach ($orders as $order)
    №{{$order->id}} от {{$order->created_at->format('m.d.y')}} в {{$order->created_at->format('H:i:s')}} выбранный менеджер: {{$order->manager ? $order->manager->name : 'любой'}}
    @endforeach
@endif

@if ($customs->count() > 0)
Заявки на индивидуальный заказ не принятые менеджерами:
@foreach ($customs as $custom)
    №{{$custom->id}} от {{$custom->date->format('m.d.y')}} в {{$custom->date->format('H:i:s')}}, выбранный менеджер: {{$custom->manager ? $custom->manager->name : 'любой'}}
@endforeach
@endif

@if ($callbacks->count() > 0)
Запросы на обратный звонок не принятые менеджерами:
@foreach ($callbacks as $callback)
    №{{$callback->id}} от {{$callback->date->format('m.d.y')}} в {{$callback->date->format('H:i:s')}}, выбранный менеджер: {{$callback->manager ? $callback->manager->name : 'любой'}}
@endforeach
@endif
