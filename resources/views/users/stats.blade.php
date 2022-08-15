@extends('layouts.app')
@section('content')

    <main class="pdg groups" id="app">
        <div class="container">
            <div class="block-bg">
                <div class="block-decor block-decor--title">
                    <div class="block-decor__in">
                        <h1 class="title">Статистика</h1>
                    </div>
                </div>
                <div class="users-table users-table--mrg">
                    <div class="row">
                        @include('common.messages')
                        {!! Form::open(['url'=>url('/users/stats'), 'method' => 'get']) !!}
                        <div class="col l4 m6 s12">
                            <label>
                                <span class="label">Группа</span>
                                <select name="stat_id" class="js-select groups_select" style="width: 100%;">
                                    <option value="all">Общая</option>
                                    <option value="numbers">Ментальный счёт</option>
                                    <option value="rombs">Флеш-карты</option>
                                </select>
                            </label>
                        </div>
                        <div id="all" class="tab-pane active">

                            <table class="flex-table data-table stats_list">
                                <thead>
                                <tr>
                                    <th><div class="sort">Имя</div></th>
                                    <th><div class="sort">кол-во ответов</div></th>
                                    <th><div class="sort">верные ответы</div></th>
                                    <th><div class="sort">неверные ответы</div></th>
                                    <th><div class="sort">успеваемость</div></th>
                                    <th><div class="sort">рейтинг</div></th>
                                </tr>
                                </thead>
                                <tbody class="js-scroll">
                                @foreach($users as $user)
                                    <tr valign="middle" class="{{$user->rang === config('rang.not_confirmed') ? 'danger' : ''}}">
                                        <td>
                                            <a href="#" data-featherlight="/images/avatars/{{$user->avatar}}">
                                                <img src="/images/avatars/{{ $user->avatar }}" alt="avatar" style="max-width: 30px; border-radius: 50%; margin-right: 8px;">
                                            </a>
                                            <a href="{{ url("/user/$user->id") }}">{{ $user->name }}</a>
                                        </td>
                                        <td>{{ $user->student['all']['answers_total'] }}</td>
                                        <td>{{ $user->student['all']['answers_correct'] }}</td>
                                        <td>{{ $user->student['all']['answers_wrong'] }}</td>
                                        <td>{{ $user->student['all']['answers_accuracy'] }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div id="numbers" class="tab-pane">
                            <table class="flex-table data-table stats_list">
                                <thead>
                                <tr>
                                    <th><div class="sort">Имя</div></th>
                                    <th><div class="sort">кол-во ответов</div></th>
                                    <th><div class="sort">верные ответы</div></th>
                                    <th><div class="sort">неверные ответы</div></th>
                                    <th><div class="sort">успеваемость</div></th>
                                    <th><div class="sort">рейтинг</div></th>
                                </tr>
                                </thead>
                                <tbody class="js-scroll">
                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                            <a href="#" data-featherlight="/images/avatars/{{$user->avatar}}">
                                                <img src="/images/avatars/{{ $user->avatar }}" alt="avatar" style="max-width: 30px; border-radius: 50%; margin-right: 8px;">
                                            </a>
                                            <a href="{{ url("/user/$user->id") }}">{{ $user->name }}</a>
                                        </td>
                                        <td>{{ $user->student['numbers']['answers_total'] }}</td>
                                        <td>{{ $user->student['numbers']['answers_correct'] }}</td>
                                        <td>{{ $user->student['numbers']['answers_wrong'] }}</td>
                                        <td>{{ $user->student['numbers']['answers_accuracy'] }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div id="rombs" class="tab-pane">
                            <table class="flex-table data-table stats_list">
                                <thead>
                                <tr>
                                    <th><div class="sort">Имя</div></th>
                                    <th><div class="sort">кол-во ответов</div></th>
                                    <th><div class="sort">верные ответы</div></th>
                                    <th><div class="sort">неверные ответы</div></th>
                                    <th><div class="sort">успеваемость</div></th>
                                    <th><div class="sort">рейтинг</div></th>
                                </tr>
                                </thead>
                                <tbody class="js-scroll">
                                @foreach($users as $user)
                                    <tr valign="middle" class="{{$user->rang === config('rang.not_confirmed') ? 'danger' : ''}}">
                                        <td>
                                            <a href="#" data-featherlight="/images/avatars/{{$user->avatar}}">
                                                <img src="/images/avatars/{{ $user->avatar }}" alt="avatar" style="max-width: 30px; border-radius: 50%; margin-right: 8px;">
                                            </a>
                                            <a href="{{ url("/user/$user->id") }}">{{ $user->name }}</a>
                                        </td>
                                        <td>{{ $user->student['rombs']['answers_total'] }}</td>
                                        <td>{{ $user->student['rombs']['answers_correct'] }}</td>
                                        <td>{{ $user->student['rombs']['answers_wrong'] }}</td>
                                        <td>{{ $user->student['rombs']['answers_accuracy'] }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if (\Auth::user()->rang === 'A')
                        <div class="col l12 s12">
                            <button type="submit" name="button" class="btn">
                                <span>Обновить</span>
                            </button>
                        </div>
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
