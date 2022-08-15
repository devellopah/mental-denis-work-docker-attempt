<main id="app" class="pdg">
    <div class="container">
        <div class="block-bg">
            @unless(count($errors))
                <div id="rolePickerOverlay" class="role-picker-overlay">
                    <div class="role-picker">
                        <div class="btns on-desktop">
                            <a href="#" class="btn-blue"><span></span><b>Выберите роль</b></a>
                        </div>
                        <div class="row">
                            <div class="col s12 text-center">
                                <button type="button" name="button" class="btn role-picker-button role-picker-button--student js-role-picker-remover"><span>Ученик</span></button>
                                <button type="button" name="button" class="btn role-picker-button role-picker-button--teacher js-role-picker-remover"><span>Учитель</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            @endunless
            <div class="row login-form text-center" style="display: none;">
                <div class="btns on-desktop">
                    <a href="#" class="btn-blue"><span></span><b>Авторизоваться</b></a>
                </div>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <div class="col l4 m6 s12 text-center {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label>
                            <span class="label">E-mail</span>
                            <input type="email" class="field" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        </label>
                        @if ($errors->has('email'))
                            <span class="help-block d-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col l4 m6 text-center s12">
                        <div class="pos-rel">
                            <label>
                                <span class="label">Пароль</span>
                                <input type="password" id="password" name="password" class="field" value="Пароль" required>
                            </label>
                            <span class="icon-pass js-pass-toggle"></span>
                            @if ($errors->has('password'))
                                <span class="help-block d-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="col s12 text-center">
                        <button type="submit" name="button" class="btn">
                            <span>Войти</span>
                        </button>
                        <a class="btn" href="{{ url('/register') }}">
                            <span>Зарегистрироваться</span>
                        </a>
                        <a class="btn" href="{{ url('/password/reset') }}">
                            <span>Забыл пароль</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>


