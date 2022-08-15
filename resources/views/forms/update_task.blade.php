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
                    {!! Form::open(['enctype'=>'multipart/form-data', 'url'=>'task/' . $task->id . '/edit']) !!}
                    <div class="form-group clearfix">
                        {!! Form::label('name','Название:', ['class'=>' col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::text('name', $task->name, ['class'=> 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('purpose', 'Цель:', ['class'=>' col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::text('purpose', $task->purpose, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('result', 'Результат:', ['class'=>' col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::text('result', $task->result, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('description_short', 'Краткое описание:', ['class'=>' col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::textarea('description_short', $task->description_short, ['class'=>'form-control', 'rows' => 3]) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('description_detail', 'Детальное описание:', ['class'=>' col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::textarea('description_detail', $task->description_detail, ['class'=>'form-control', 'rows'=> 5]) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('starting_at', 'Дата начала:', ['class'=>' col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::input('date', 'starting_at', \Carbon\Carbon::parse($task->starting_at)->format('Y-m-d'),
                             ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('expires_at', 'Дата завершения:', ['class'=>' col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::input('date', 'expires_at' , \Carbon\Carbon::parse($task->expires_at)->format('Y-m-d'), ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('executor_id', 'Исполняющий задание:', ['class'=>' col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::select('executor_id', $executors_display, $task->executor_id, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        {!! Form::label('category_id', 'Курс:', ['class'=>'col-md-4']) !!}
                        <div class="col-md-6">
                            {!! Form::select('category_id', $categories_display, !empty($task->category_id) ? $task->category_id : null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            {!! Form::label('files[]', 'Дополнительные файлы', ['class'=>'btn btn-raised btn-default']) !!}
                            {!! Form::input('file', 'files[]', null, ['class'=>'hidden', 'multiple'=> '']) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="col-md-12">
                            {!! Form::label('image', 'Изображение задачи', ['class'=>'btn btn-raised btn-default']) !!}
                            {!! Form::input('file', 'image', null, ['class'=>'', 'id'=>'image']) !!}
                        </div>
                    </div>
                    @if(!empty($taskFiles))
                        <div class="form-group col-md-12">
                            <h4>Удалить файлы:</h4>

                            @foreach($taskFiles as $id=>$fileType)
                                @foreach($fileType as $id_file=>$file)
                                    <div class="form-group clearfix">
                                        {!! Form::label('removeFiles[' . $file['id'] . ']', $file['name'], ['class'=>' col-md-7']) !!}
                                        <div class="col-md-4">
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('removeFiles['.$file['id'] .']', $file['src'], false, ['class'=>'']) !!}
                                                    <span class="checkbox-material"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    @endif
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                    @endif
                    <div class="form-group clearfix col-md-12">
                        {!! Form::submit('Обновить', ['class'=>'btn btn-raised btn-primary ']) !!}
                    </div>
                    <br>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@stop

