@extends('layouts.app')
@section('content')

    <main id="app" class="pdg">
        <div class="container">
            <div class="block-bg">
                <div class="row reset-form text-center">
                    <div class="btns on-desktop">
                        <span class="btn-blue"><span></span><b>Добавление ученика в группу</b></span>
                    </div>
                    @include('common.messages')

                    {!! Form::open() !!}
                    {{ csrf_field() }}
                        <div class="col l4 m6 s12 text-center">
                            <label>
                                <span class="label">Группы</span>
                                {!! Form::select('group_id', $groups, null, ['class'=>'js-select', 'style' => 'width: 100%;']) !!}
                            </label>
                        </div>
                        <div class="col l4 m6 s12 text-center">
                            <label>
                                <span class="label">Студенты</span>
                                {!! Form::select('user_id', $users, null, ['class'=>'js-select', 'style' => 'width: 100%;']) !!}
                            </label>
                        </div>
                    <div class="col l12 s12">
                        <button type="submit" name="button" class="btn">
                            <span>Добавить в группу</span>
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </main>

@endsection
