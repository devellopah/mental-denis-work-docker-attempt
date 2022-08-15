@extends('layouts.app')
@section('content')
    <main id="app" class="pdg">
        <div class="container">
            <div class="block-bg">
                <div id="rolePickerOverlay" class="role-picker-overlay">
                    <div class="role-picker">
                        <div class="btns on-desktop">
                            <a class="btn-blue"><span></span><b>Тарифы</b></a>
                        </div>
                    </div>
                </div>
                <div class="row login-form">
                    @foreach($tariffs->all() as $tariff)
                        <div class="col l4 m6 s12 text-center tariff">
                            <p class="text-muted">
                                <strong>Описание:</strong> {{$tariff->description}}
                            </p>
                            <p><strong>Срок:</strong> {{$tariff->duration}} дней</p>
                            <p><strong>Стоимость:</strong> {{$tariff->cost}} рублей</p>
                            @if (\Auth::user()->rang === 'A')
                                <p>
                                    <a href="{{url("payment/tariffs/$tariff->id")}}" class="btn"><span>Редактировать</span></a>
                                    <a href="{{url("payment/tariffs/$tariff->id/delete")}}" class="btn"><span>Удалить</span></a>
                                    <a href="{{url("payment/$tariff->id/process")}}" class="btn"><span>Оплатить</span></a>
                                </p>
                            @else
                                <p><a href="{{url("payment/$tariff->id/process")}}" class="btn"><span>Оплатить</span></a>
                            @endif
                        </div>
                    @endforeach
                    @if (\Auth::user()->rang === 'A')
                            <div class="col s12 text-center">
                                <a href="{{url("/payment/tariffs/new")}}" class="btn"><span>Добавить новый</span></a>
                                <a href="{{url("/payment/stat")}}" class="btn"><span>Все платежи</span></a>
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </main>

@endsection