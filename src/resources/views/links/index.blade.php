@extends('layout')

@section('header')

@endsection


@section('content')
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                Сокращатель ссылок
            </div>

            <form class="input-data" id="shot-link" method="POST">
                {{ csrf_field() }}
                <fieldset>
                    <div class="item">
                        <label for="link-input" >Исходная ссылка</label>
                        <input id="link-input" required name="link-input" class="link-input" type="text">
                    </div>
                    <div class="item">
                        <label for="self-text">Короткая ссылка</label>
                        <input id="self-text" name="self-text" class="link-input" type="text">
                    </div>
                    <div class="item">
                        <label for="expireDate">Активна до</label>
                        <input id="expireDate" name="expireDate" class="link-input" type="datetime-local" value="{!! date('Y-m-d\TH:i:s', strtotime("+1 day")) !!}">
                    </div>
                    <div class="item">
                        <label for="commercial">Коммерческая ссылка</label>
                        <input id="commercial" name="commercial" class="link-input-checkbox" type="checkbox">
                    </div>
                </fieldset>
                <button class="button">Уменьшить</button>

            </form>
            <div class="output-data">

                <div class="item">
                    <label for="link-output">Короткая ссылка</label>
                    <input id="link-output" class="link-input" disabled type="text">
                    <button class="button copy">Копировать</button>
                </div>
                <div class="item">
                    <label for="link-statistics">Ссылка статистики</label>
                    <input id="link-statistics" class="link-input" disabled type="text">
                    <button class="button copy">Копировать</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
 <script src="./js/app.js"></script>
@endsection
