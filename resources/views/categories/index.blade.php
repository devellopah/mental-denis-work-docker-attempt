@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3 class="page-header">Список категорий</h3>
            @include('common.messages')
            {!! Form::open(['route' => 'categories.destroyMany']) !!}
            <table class="table table-striped valign-middle">
                <thead>
                <tr>
                    <td>Название</td>
                    <td class="text-center">Изменить</td>
                    <td class="text-center">Удалить</td>
                </tr>
                </thead>
                <tbody>
                @foreach($taskCategories as $taskCategory)
                    <tr>
                        <td>{{$taskCategory->name}}</td>
                        <td class="text-center">
                            <a href="{{route('categories.update', ['id' => $taskCategory->id])}}">
                                <i class="material-icons">&#xE254;</i>
                            </a>
                        </td>
                        <td align="center">
                            <div class="checkbox">
                                <label>
                                    {!! Form::checkbox('removeCategory['. $taskCategory->id .']', $taskCategory->id, false, ['class'=>'']) !!}
                                </label>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="float-right clearfix">
                <div class="form-group clearfix col-md-12">
                    <div class="row">
                        <a href="{{route('categories.create')}}" class="btn btn-raised btn-danger btn-lg">Добавить</a>
                        {!! Form::submit('Обновить', ['class'=>'btn btn-raised btn-warning btn-lg']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection