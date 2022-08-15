@extends('layouts.app')

@section('content')


    <main class="pdg" id="app">
        <div class="container">
            <div class="block-bg users_list">
                <div class="block-decor block-decor--title">
                    <div class="block-decor__in">
                        <h1 class="title">Список пользователей</h1>
                    </div>
                </div>
                <div class="btns">
                    <a href="#" class="btn-blue icon-arrow-back on-desktop"><span></span></a>
                    @if(\Auth::user()->rang === config('rang.admin'))
                        <a href="{{ url('/user/create') }}" class="btn-blue icon-add"><span></span></a>
                    @endif
                </div>
                <div class="users-table users-table--mrg">

                    @include('common.messages')

                    {!! Form::open(['url'=>url('/users')]) !!}

                    <table class="flex-table data-table users_list">
                        <thead>
                        <tr>
                            <th data-field="user" data-sortable="true"><div class="sort">Пользователь</div></th>
                            <th><div class="sort">Активация</div></th>
                            <th><div class="sort sort--up">Осталось</div></th>
                            <th><div class="sort sort--up">Статус</div></th>
                            <th><div class="sort sort--up">E-mail</div></th>
                            @if (\Auth::user()->rang === 'A')
                                <th>Удалить</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody class="js-scroll">
                        @foreach($users as $user)
                            <tr valign="middle" class="{{$user->rang === config('rang.not_confirmed') ? 'danger' : ''}}">
                                <td data-field="user">
                                    <a href="#" data-featherlight="/images/avatars/{{$user->avatar}}">
                                        <img class="student__img" src="/images/avatars/{{$user->avatar}}" alt="">
                                    </a>
                                    <a class="student__name" href="{{url('/user/' . $user->id)}}">{{$user->name}}</a>
                                </td>
                                <td>@if($user->rang == 'F') <span class="inact">Неактивен</span> @else <span class="act">Активен</span> @endif</td>
                                <td>3 дня</td>
                                <td>{{config('rang.' . $user->rang)}}</td>
                                <td>{{ $user->email }}</td>
                                @if (\Auth::user()->rang === 'A')
                                    <td>
                                        <label class="switch switch--sm">
                                            <input class="switch_checkbox" type="checkbox" @if($user->rang != 'F') checked @endif>
                                            <span class="switch__bar"></span>
                                            <input type="hidden" name="changeRang[{{$user->id}}]" value="@if($user->rang != 'F') active @else noactive @endif" >
                                        </label>
                                        <a class="delete delete-link" title="Удалить"></a>
                                        {!! Form::checkbox('removeUser['. $user->id .']', $user->id, false, ['class'=>'remove_checkbox']) !!}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if (\Auth::user()->rang === 'A')
                        <div class="col l12 s12 text-center">
                            <button type="submit" name="button" class="btn"><span>Обновить</span></button>
                        </div>
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </main>

@endsection
