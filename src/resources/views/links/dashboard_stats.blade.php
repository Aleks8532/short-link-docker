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
            <h1>Общая статистика</h1>
            <table class="table" style="margin-top: 20px">
                <thead>
                    <tr>
                        <th scope="col">Целевая ссылка</th>
                        <th scope="col">Короткая ссылка</th>
                        <th scope="col">Уникальных посетителей</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($stats as $item)
                    <tr>
                        <td>{{ $item->link_full }}</td>
                        <td>{{ $item->link_alias }}</td>
                        <td>{{ $item->count_clients }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

@endsection
