@extends('layouts.app')
@section('content')

    <main id="app" class="pdg">
        <div class="container">
            <div class="block-bg">
                <div id="rolePickerOverlay" class="role-picker-overlay">
                    <div class="role-picker">
                        <div class="btns on-desktop">
                            <a class="btn-blue"><span></span><b>{{ $tariff->name }} | Редактировать</b></a>
                        </div>
                    </div>
                </div>
                <div class="row add_tariff">
                    {!! Form::open(array('url' => 'payment/tariffs/'.$tariff->id)) !!}
                    @if( $messages['text'] != '')
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <p class="bg-{{ $messages['code'] }}">{{ $messages['text'] }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Название</span>
                            <input type="text" class="field" name="name" value="{{ $tariff->name }}" required autofocus>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Описание</span>
                            <textarea class="field" name="description">{{ $tariff->description }}</textarea>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Продолжительность (дней)</span>
                            <input type="text" class="field" name="duration" value="{{ $tariff->duration }}" required autofocus>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Стоимость (рублей)</span>
                            <input type="text" class="field" name="cost" value="{{ $tariff->cost }}" required autofocus>
                        </label>
                    </div>
                    <div class="col s12 text-center">
                        <button type="submit" name="button" class="btn">
                            <span>Изменить</span>
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