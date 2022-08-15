<main id="app" class="pdg">
    <div class="container">
        <div class="block-bg">
            <div class="row registr-form text-center">
                <div class="btns on-desktop">
                    <a href="#" class="btn-blue"><span></span><b>Регистрация</b></a>
                </div>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                    {{ csrf_field() }}
                    <div class="col l3 m6 s12 text-center{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label>
                            <span class="label">Имя</span>
                            <input id="name" type="text" class="field" name="name" value="{{ old('name') }}" required autofocus>
                        </label>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col l3 m6 s12 text-center{{ $errors->has('email') ? ' has-error' : '' }}">
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
                    <div class="col l3 m6 s12 text-center{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label>
                            <span class="label">Пароль</span>
                            <input id="password" type="password" class="field" name="password" required>
                        </label>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col l3 m6 s12 text-center{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
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
                            <span>Зарегистрироваться</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

