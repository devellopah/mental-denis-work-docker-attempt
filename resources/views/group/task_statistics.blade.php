@extends('layouts.app')

@section('content')

    <div class="View pdg">

        <div class="container tasks">
            <div class="block-bg">
                <div class="block-decor block-decor--title">
                    <div class="block-decor__in">
                        <h1 class="title">Статистика выполнения задания</h1>
                    </div>
                </div>
                <div class="users-table users-table--mrg">
                    <div class="row text-center">
                        <table class="flex-table data-table">
                            <thead>
                            <tr>
                                <th class="text-left">Исполнитель</th>
                                <th class="text-left">Выполнение</th>
                            </tr>
                            </thead>
                            <tbody class="js-scroll">
                            @foreach ($students as $student)
                                <tr>
                                    <td>
                                        {{$student->username}}
                                    </td>
                                    @if( $student->pivot->is_finished )
                                        <td>
                                            <p>Старт - {{$student->pivot->started_time}}</p>
                                            <p>Время выполнения - {{$student->pivot->lead_time}}</p>
                                            <p>Успеваемость - {{$student->pivot->accuracy}}</p>
                                        </td>
                                    @else
                                        <td>
                                            <p>В процессе</p>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
