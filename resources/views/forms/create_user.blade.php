
<main id="app" class="pdg">
    <div class="container">
        <div class="block-bg">
            <div class="row reset-form text-center" id="groupContainer">
                <div class="btns on-desktop">
                    <a href="#" class="btn-blue"><span></span><b>Добавление пользователя</b></a>
                </div>
                @include('common.messages')
                { {!! Form::open() !!}
                {{ csrf_field() }}
                @include('common.messages')
                <div class="col l4 m6 s12 text-center {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label>
                        <span class="label">Имя</span>
                        <input id="name" type="text" class="field" name="name" value="{{ old('name') }}" required autofocus>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </label>
                </div>
                <div class="col l4 m6 s12 text-center {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label>
                        <span class="label">Email</span>
                        <input id="email" type="email" class="field" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </label>
                </div>
                <div class="col l4 m6 s12 text-center {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label>
                        <span class="label">Пароль</span>
                        <input id="password" type="password" class="field" name="password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </label>
                </div>
                <div class="col l4 m6 s12 text-center {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label>
                        <span class="label">Повтор пароля</span>
                        <input id="password-confirm" type="password" class="field" name="password_confirmation" required>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif

                    </label>
                </div>
                <div class="col l4 m6 s12 text-center">
                    <label>
                        <span class="label">Уровень доступа</span>

                        {!! Form::select('rang',  \Auth::user()->rang === config('rang.admin')
                                ? ['E'=>'Ученик', 'C' => 'Преподаватель','A' => 'Администратор']
                                : ['E'=>'Ученик'], null, ['class'=>'js-select', 'style' => 'width: 100%;']) !!}

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif

                    </label>
                </div>
                <div class="col l12 s12">
                    <button type="submit" name="button" class="btn">
                        <span>Зарегистрировать</span>
                    </button>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</main>

