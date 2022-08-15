@extends('layouts.app')
@section('content')

    <main class="pdg" id="app">
        <div class="container">
            <div class="block-bg users_list">
                <div class="block-decor block-decor--title">
                    <div class="block-decor__in">
                        <h1 class="title">Все платежи</h1>
                    </div>
                </div>
                <div class="users-table users-table--mrg">
                    <table class="flex-table valign-middle data-table" id="users_list">
                        <thead>
                        <tr>
                            <th>Пользователь</th>
                            <th>Тариф</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th>Детали</th>
                            <th>Оплачено до</th>
                        </tr>
                        </thead>
                        <tbody class="js-scroll">
                        @foreach($payments->all() as $payment)
                            <tr>
                                @if ($payment->user['rang'] == 'A')
                                    <td>{{ $payment->user['name'] }}</td>
                                @else
                                    <td>{{ $payment->name }}</td>
                                @endif
                                <td>{{ $payment->tariff->name }}</td>
                                <td>{{ $payment->cost }}</td>
                                <td>@if($payment->status == 'succeeded') Успешно @else Отмена @endif</td>
                                <td>{!! $payment->details !!}</td>
                                <td>
                                    {{ date('d.m.Y', strtotime($payment->created_at->addDays($payment->tariff->duration))) }} &nbsp;&nbsp;&nbsp;
                                    <a href="{{url("/payment/transaction/$payment->id/delete")}}">Удалить</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                    </table>
                    <div class="col l12 s12 text-center">
                        <a href="{{url('/payment/tariffs')}}" class="btn">Назад</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection