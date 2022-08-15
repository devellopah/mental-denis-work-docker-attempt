@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h3>Добавление категории задания</h3>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('common.messages')
                    {!! Form::model($taskCategory, ['route' => ['categories.update', $taskCategory->id], 'method' => 'put']) !!}
                    @include('categories.model_form')
                    <div class="form-group clearfix">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-raised btn-primary">
                                Изменить
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection