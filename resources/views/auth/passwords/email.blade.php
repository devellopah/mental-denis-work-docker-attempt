@extends('layouts.app')
@section('content')
    <main id="app" class="pdg">
        <div class="container">
            <div class="block-bg">
                <div class="row reset-form text-center">
                    <div class="btns on-desktop">
                        <a href="#" class="btn-blue"><span></span><b>Восстановить пароль</b></a>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}
                        <div class="col l4 m6 s12 text-center{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label>
                                <span class="label">Email</span>
                                <input id="email" type="email" class="field" name="email" value="{{ old('email') }}" required>
                            </label>
                            @if ($errors->has('email'))
                                <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                            @endif
                        </div>
                        <div class="col s12 text-center">
                            <button type="submit" name="button" class="btn">
                                <span>Выслать пароль</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection