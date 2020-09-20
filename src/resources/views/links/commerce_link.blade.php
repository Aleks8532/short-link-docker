@extends('layout')
@section('header')
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Переход по ссылке</title>
@endsection


@section('content')
        <h1>Переход по ссылке начнется через <span id="counter">5</span> секунд</h1>
        <img width="500" src="{{ $image }}"  />
@endsection

@section('footer')
    <script>
        function countdown() {
            var i = document.getElementById('counter');
            if (parseInt(i.innerHTML) < 1) {
                location.href = "{{ $destination }}";
            } else {
                i.innerHTML = parseInt(i.innerHTML)-1;
            }
        }
        setInterval(function(){ countdown(); },1000);
    </script>
@endsection


