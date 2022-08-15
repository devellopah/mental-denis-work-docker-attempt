@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h3>Добавление упражнения</h3>
            </div>
            @include('common.messages')
            {!! Form::model(
                new App\TrainerTask(), 
                ['route' => ['trainers.categories.exercises.trainer_task.store', $trainer_id, $category_id, $exercise_id]]
            ) !!}
            @include('trainer_task.forms.model')
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