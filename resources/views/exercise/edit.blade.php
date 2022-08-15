@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="page-header">
            <h3>Редактирование упражнения</h3>
        </div>
        @include('common.messages')
        {!! Form::model($exercise, ['route' => ['trainers.categories.exercises.update', $trainer_id, $category_id, $exercise->id], 'method' => 'PATCH']) !!}
        @include('exercise.model')
        <div class="row">
            <div class="col-md-6 col-md-offset-4">
                <div class="form-group clearfix">
                    <button type="submit" class="btn btn-raised btn-primary">
                        Сохранить
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
