@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="page-header">
            <h3>Переименовать категорию</h3>
            </div>

            @include('common.messages')

            {!! Form::model($category, ['method'=> 'patch', 'route' => ['trainers.categories.update', $trainer_id, $category->id]]) !!}

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
