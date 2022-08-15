@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-top">
            <h3 class="page-header">Список пользователей</h3>
            @if( \Auth::user()->rang === config('rang.creator') || \Auth::user()->rang === config('rang.admin'))
            <a class="add-user-link" href="{{ url('/user/create') }}">
                <span>Добавить пользователя</span>
            </a>
            @endif
        </div>

        @include('common.messages')

        {!! Form::open(['url'=>url('/users')]) !!}
        <table class="table table-striped valign-middle data-table">
            <thead>
            <tr>
                <th class="text-left">№</th>
                <th class="text-left">Имя</th>
                <th align="left" class="text-left">Email</th>
                <th align="left" class="text-left">Ранг</th>
                @if( \Auth::user()->rang === config('rang.creator') || \Auth::user()->rang === config('rang.admin'))
                    {{-- <th class="text-center">Поставить задачу</th> --}}
                    {{--                     <th class="text-center">Написать сообщение</th>
                        --}}
                    <th class="text-center">Удалить</th>
                @endif

            </tr>
            </thead>
            @foreach($users as $user)
                <tr valign="middle" class="{{$user->rang === config('rang.not_confirmed') ? 'danger' : ''}}">
                    <td class="text-left">{{empty($i) ? $i = 1 : $i = $i + 1}}</td>
                    <td class="text-left text-left--flex">
                            <a href="#" data-featherlight="/images/avatars/{{$user->avatar}}">
                                <img src="/images/avatars/{{ $user->avatar }}" alt="avatar" style="max-width: 30px; border-radius: 50%; margin-right: 8px;">                     
                            </a>
                        <a href="{{url('/user/' . $user->id)}}">{{$user->name}}</a>
                    </td>
                    <td class="text-left">{{$user->email}}</td>
                    <td class="text-left">{{config('rang.' . $user->rang)}}</td>
                    @if( \Auth::user()->rang === config('rang.creator') || \Auth::user()->rang === config('rang.admin'))
                        {{-- <td class="text-center">
                            @if($user->rang === config('rang.executor'))
                                <a href="{{url('/user/' . $user->id) . '/create_task'}}"
                                    title="поставить задачу">
                                    <i class="material-icons">&#xE85D;</i>
                                </a>
                            @endif
                        </td> --}}
                        {{-- <td class="text-center">
                            <a href="{{url('/user/' . $user->id .'/create_message')}}" class="">
                                <i class="material-icons">&#xE0C9;</i>
                            </a>
                        </td> --}}

                        <td align="center">
                            <div class="checkbox">
                                <label>
                                    {!! Form::checkbox('removeUser['. $user->id .']', $user->id, false, ['class'=>'']) !!}
                                    <span class="checkbox-material"></span>
                                </label>
                            </div>
                        </td>
                    @endif

                </tr>
            @endforeach
        </table>
        @if( \Auth::user()->rang === config('rang.creator') || \Auth::user()->rang === config('rang.admin'))
            <div class="float-right clearfix">
                <div class="form-group clearfix col-md-12">
                    {!! Form::submit('Обновить', ['class'=>'btn btn-raised btn-danger btn-lg']) !!}
                </div>
            </div>
        @endif
        {!! Form::close() !!}
        
    </div>
@endsection
