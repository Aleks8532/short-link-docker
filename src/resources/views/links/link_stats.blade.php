@extends('layout')
@section('header')
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Статистика переходов по ссылке</title>

        <!-- Bootstrap -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
                rel="stylesheet"
                integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
                crossorigin="anonymous">
@endsection


@section('content')

        <div class="starter-template">
            <h1>Статистика переходов</h1>
            Целевая ссылка: <a href="{{ $link->link_full }}">{{ $link->link_full }}</a><br>
            Короткая ссылка: <a href="{{ "/i/$link->link_alias" }}">{{ $link->link_alias }}</a><br>
            <table class="table" style="margin-top: 20px">
                <thead>
                    <tr>
                        <th scope="col">Посетитель</th>
                        <th scope="col">Показанное изображение</th>
                        <th scope="col">Время перехода</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($stats as $item)
                    <tr><td>{{ $item->client_id }}</td><td><a href="/storage/{{ $item->image_path }}">{{ $item->image_path }}</a></td><td>{{ $item->created_at }}</td></tr>
                @endforeach
                </tbody>
            </table>
        </div>
@endsection
