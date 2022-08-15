@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h3>Изменение упражнения</h3>
            </div>
            @include('common.messages')
            {!! Form::model($task, 
                ['route' => [ 'trainers.categories.exercises.trainer_task.update', $trainer_id, $category_id, $exercise_id, $task->id ], 
                'method' => 'patch']) !!}
            @include('trainer_task.forms.model')
            <div class="form-group clearfix">
                <div class="col-md-6 col-md-offset-4">
                    <a href="/trainers/{{$trainer_id}}/categories/{{$category_id}}/exercises/{{$exercise_id}}/trainer_task" class="btn btn-raised btn-danger">Назад</a>
                    <button type="submit" class="btn btn-raised btn-primary">
                        Сохранить
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection