@extends('layouts.app')
@section('content')
    <main id="app" class="pdg">
        <div class="container">
            <div class="block-bg">
                <div id="rolePickerOverlay" class="role-picker-overlay">
                    <div class="role-picker">
                        <div class="btns on-desktop">
                            <a class="btn-blue"><span></span><b>Добавить новый тариф</b></a>
                        </div>
                    </div>
                </div>
                <div class="row add_tariff">
                    {!! Form::open(array('url' => '/payment/tariffs/add')) !!}
                    @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Название</span>
                            <input type="text" class="field" name="name" value="{{  Request::old('name') }}" required autofocus>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Описание</span>
                            <textarea class="field" name="description">{{  Request::old('description') }}</textarea>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Продолжительность (дней)</span>
                            <input type="text" class="field" name="duration" value="{{  Request::old('duration') }}" required autofocus>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Стоимость (рублей)</span>
                            <input type="text" class="field" name="cost" value="{{  Request::old('cost') }}" required autofocus>
                        </label>
                    </div>
                    <div class="col s12 text-center">
                        <button type="submit" name="button" class="btn">
                            <span>Добавить</span>
                        </button>
                        <a class="btn" href="{{ url('/payment/tariffs') }}">
                            <span>Назад к тарифам</span>
                        </a>
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </main>

@endsection