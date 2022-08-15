@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h3>Добавление задания</h3>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('common.messages')
                    {!! Form::open(['enctype'=>'multipart/form-data']) !!}
                    <div class="form-group clearfix">
                        {!! Form::label('name','Название:', ['class'=>'col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::text('name', old('name'), ['class'=> 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('purpose', 'Цель:', ['class'=>' col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::text('purpose', null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('result', 'Результат:', ['class'=>' col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::text('result', null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('description_short', 'Краткое описание:', ['class'=>'col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::textarea('description_short', null, ['class'=>'form-control', 'rows' => 3]) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('description_detail', 'Детальное описание:', ['class'=>'col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::textarea('description_detail', null, ['class'=>'form-control', 'rows'=>5]) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('starting_at', 'Дата начала:', ['class'=>'col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::input('date', 'starting_at', \Carbon\Carbon::now()->format('Y-m-d'), ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('expires_at', 'Дата завершения:', ['class'=>'col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::input('date', 'expires_at' , \Carbon\Carbon::tomorrow()->format('Y-m-d'), ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('executor_id', 'Исполняющий задание:', ['class'=>'col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::select('executor_id', $executors_display, !empty($executorId) ? $executorId : null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('category_id', 'Курс:', ['class'=>'col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::select('category_id', $categories_display, !empty($categoryId) ? $categoryId : null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            {!! Form::label('image', 'Изображение задачи', ['class'=>'btn btn-raised btn-default']) !!}
                            {!! Form::input('file', 'image', null, ['class'=>'', 'id'=>'image']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            {!! Form::label('files', 'Добавить файлы', ['class'=>'btn btn-raised btn-default']) !!}
                            {!! Form::input('file', 'files[]', null, ['class'=>'hidden', 'multiple'=> '', 'id'=>'files']) !!}
                        </div>
                    </div>
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                    @endif
                    <div class="form-group clearfix col-md-12">
                        {!! Form::submit('Создать задание', ['class'=>'btn btn-primary btn-raised']) !!}
                    </div>
                    <br>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

