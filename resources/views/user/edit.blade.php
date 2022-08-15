@extends('layouts.app')
@section('content')

    <main class="pdg">
        <div class="container">
            <div class="block-bg profile">
                <div class="user-photo on-desktop">
                    <a href="#" data-featherlight="/images/avatars/{{$user->avatar}}">
                        <img src="/images/avatars/{{$user->avatar}}" alt="">
                    </a>
                </div>
                <div class="acc__btns btns">
                    @if (\Auth::user()->rang === 'A')
                        {!! Form::open(['url'=>url('/users')]) !!}
                        <button class="btn-blue icon-del delete-link" title="Удалить пользователя"><span></span></button>
                        {!! Form::checkbox('removeUser['. $user->id .']', $user->id, false, ['class'=>'remove_checkbox']) !!}
                        {!! Form::close() !!}
                    @endif
                </div>
                {!! Form::open(['files' => true]) !!}

                @if (\Auth::user()->rang === 'A')
                <div class="acc__top">
                    <div class="acc__top-right">
                        <span class="label label--inline">Активация</span>
                        <label class="switch">
                            <input type="checkbox" name="rang" class="switch_checkbox"@if($user->rang != 'F') checked @endif>
                            <span class="switch__bar"></span>
                        </label>
                    </div>
                </div>
                @endif
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                @endif
                @include('common.messages')
                <div class="row">
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">ФИО</span>
                            <input type="text"  id="name" name="name" class="field" value="{{$user->name}}" />
                        </label>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">E-mail</span>
                            <input name="email" type="email" value="{{$user->email}}" id="email" class="field">
                        </label>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col l4 m6 s12">
                        <div class="pos-rel">
                            <label>
                                <span class="label">Пароль</span>
                                <input name="password" type="password" value="" id="password" class="field">
                            </label>
                            <span class="icon-pass js-pass-toggle"></span>
                        </div>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col l4 m6 s12">
                        <div class="pos-rel">
                            <label>
                                <span class="label">Подверждение пароля</span>
                                <input name="password_confirmation" type="password" value="" id="password_confirmation" class="field">
                            </label>
                            <span class="icon-pass js-pass-toggle"></span>
                        </div>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col l12 s12 text-center">
                        <button type="submit" name="button" class="btn"><span>Сохранить</span></button>
                        <label for="avatar" id="profileAvatarRefresher" class="btn profile-form__label--avatar">
                            Обновить аватарку
                        </label>
                        <input id="avatar" placeholder="Обновить аватарку" name="avatar" type="file" class="hide">
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </main>
@endsection