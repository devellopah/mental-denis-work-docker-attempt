@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="page-top">
            <h3 class="page-header">{{ $tariff->name }} | Оплата</h3>
        </div>
        <div class="row clearfix">
            <div class="col-md-12">
                <p>Сумма к оплата : {{ $tariff->cost }} рублей.</p>
                <form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml">
                    <input type="hidden" name="receiver" value="41001314651635">
                    <input type="hidden" name="quickpay-form" value="shop">
                    <input type="hidden" name="paymentType" value="AC">
                    <input type="hidden" name="formcomment" value="">
                    <input type="hidden" name="short-dest" value="">
                    <input type="hidden" name="label" value="$order_id">
                    <input type="hidden" name="targets" value="транзакция {order_id}">

                    <input type="hidden" name="sum" value="{{ $tariff->cost }}" data-type="number">
                    <input type="hidden" name="comment" value="">

                    <input type="hidden" name="need-fio" value="false">
                    <input type="hidden" name="need-email" value="false">
                    <input type="hidden" name="need-phone" value="false">
                    <input type="hidden" name="need-address" value="false">
                    <input type="submit" value="Перевести">
                </form>
            </div>
        </div>
    </div>


@endsection