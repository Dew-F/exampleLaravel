@extends('templates.base')

@section('directory', 'Продукция по параметрам заказчика')
@section('title', 'Заявка на индивидуальный заказ')
@section('keywords', 'Заказ, заявка, заказ по параметрам')
@section('description', 'Описание заказа')

@section('content')
    <div class="custom">
        <div class="custom-container">
            <div class="tabs">
                <div class="tab"><a href="{{route('production')}}">Продукция</a></div>
                <div class="tab active">Продукция<br>по параметрам</div>
            </div>
            <div class="tab-container">
                Если вы не нашли нужного вам товара или хотите приобрести что-то особенное,
                здесь вы можете составить описание нужной вам продукции и оставить заявку на составление заказа.
                <form id="custom" method="post" action="{{route('custom.send')}}">
                    @csrf
                    <input type="text" form="custom" name="name" placeholder="ФИО" value="{{old('name') ?? ''}}" required><br>
                    <input type="text" form="custom" name="phone" placeholder="Телефон для связи" value="{{old('phone') ?? ''}}" required><br>
                    <input type="text" form="custom" name="email" placeholder="E-mail для связи" value="{{old('email') ?? ''}}" required><br>
                    <textarea form="custom" name="description" placeholder="Описание заказа" required>{{old('description') ?? ''}}</textarea><br>
                    <input type="hidden" form="custom" name="sample" value="">
                    <div class="g-recaptcha recaptcha" data-sitekey="{{config('services.recaptcha.siteKey')}}"></div>
                    <button type="submit" form="custom" class="greenGradient">Оставить заявку</button>
                </form>
                @if ($errors->any())
                    <span class="redText">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </span><br>
                @endif
                @if ($message = Session::get('success'))
                    <span class="greenText">{{ $message }}</span>
                @endif
            </div>
        </div>
        @include('modules.filter')
    </div>
@endsection

@push('scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endpush
