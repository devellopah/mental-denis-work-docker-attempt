<main id="app" class="pdg">
    <div class="container">
        <div class="block-bg">
            <div class="row reset-form text-center" id="groupContainer">
                <div class="btns on-desktop">
                    <a href="#" class="btn-blue"><span></span><b>Добавление группы</b></a>
                </div>
                @include('common.messages')

                { {!! Form::open() !!}
                {{ csrf_field() }}
                @include('common.messages')
                <div class="col l4 m6 s12 text-center {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label>
                        <span class="label">Название группы</span>
                        <input id="name" type="text" class="field" name="name" value="{{ old('name') }}" required autofocus>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                        @endif
                    </label>
                </div>
                <div class="col l4 m6 s12 text-center">
                    <label>
                        <span class="label">Тема</span>
                        {!! Form::select('theme', [], null, ['class'=>'js-select', 'style' => 'width: 100%;']) !!}
                    </label>
                </div>
                <div class="col l4 m6 s12 text-center">
                    <label>
                        <span class="label">Уровень</span>
                        {!! Form::select('level', [], null, ['class'=>'js-select', 'style' => 'width: 100%;']) !!}
                    </label>
                </div>
                <div class="col l12 s12">
                    <button type="submit" name="button" class="btn">
                        <span>Создать</span>
                    </button>
                </div>

                {{ Form::hidden('user_id', auth()->user()->id) }}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</main>

