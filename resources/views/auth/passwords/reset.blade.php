@extends('layouts.app')
@section('content')
    <main id="app" class="pdg">
        <div class="container">
            <div class="block-bg">
                <div class="row reset-form text-center">
                    <div class="btns on-desktop">
                        <a href="#" class="btn-blue"><span></span><b>Восстановление пароля</b></a>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="col l4 m6 s12 text-center{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label>
                                <span class="label">Email</span>
                                <input id="email" type="email" class="field" name="email" value="{{ $email or old('email') }}" required autofocus>
                            </label>
                            @if ($errors->has('email'))
                                <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                            @endif
                        </div>
                        <div class="col l4 m6 s12 text-center{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label>
                                <span class="label">Пароль</span>
                                <input id="password" type="password" class="form-control" name="password" required>
                            </label>
                            @if ($errors->has('password'))
                                <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                            @endif
                        </div>
                        <div class="col l4 m6 s12 text-center{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label>
                                <span class="label">Повторить пароль</span>
                                <input id="password-confirm" type="password" class="field" name="password_confirmation" required>
                            </label>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                            @endif
                        </div>
                        <div class="col s12 text-center">
                            <button type="submit" name="button" class="btn">
                                <span>Сбросить пароль</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
