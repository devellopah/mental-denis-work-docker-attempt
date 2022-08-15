@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h3>Добавить категорию</h3>
            </div>
            @include('common.messages')
            {!! Form::model(new App\TrainerTaskCategory(), ['route' => ['trainers.categories.store', $trainer_id]]) !!}
            @include('trainer_task.forms.category_model')
            <div class="form-group clearfix">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-raised btn-primary">
                        Сохранить
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection