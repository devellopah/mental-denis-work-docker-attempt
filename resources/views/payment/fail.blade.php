@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="page-top">
            <h3 class="page-header">Оплата не прошла</h3>
        </div>
        <div class="row clearfix">
            <div class="col-md-6">
                <a href="/user/profile/" class="btn btn-raised btn-danger btn-md">Перейти в профиль</a>
                <a href="/payment/tariffs" class="btn btn-raised btn-danger btn-md">Назад к оплате</a>
            </div>
        </div>
    </div>

@endsection