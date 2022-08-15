@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            @include('common.messages')
        </div>
    </div>
    <div class="container bs-callout clearfix">
        <div class="row">
            <div class="well clearfix">
                <div class="col-sm-9 col-xs-12">
                    <h3 class="task__name">Задача: {{$task->name}}</h3>
                    <div class="task__description">
                        {{$task->description_detail}}
                    </div>
                    <div class="task__stats">
                        @if(!empty($task->purpose))
                            <div class="flex-center task__stat">
                                <i class="text-primary material-icons">&#xE021;</i><b>Цель:</b>
                                {{$task->purpose}}
                            </div>
                        @endif
                        @if(!empty($task->category))
                            <div class="flex-center task__stat">
                                <i class="material-icons text-primary">&#xE254;</i><b>Курс:</b>
                                {{$task->category->name}}
                            </div>
                        @endif
                        @if(!empty($task->result))
                            <div class="flex-center task__stat">
                                <i class="text-primary material-icons">&#xE86C;</i><b>Результат:</b>
                                {{$task->result}}
                            </div>
                        @endif
                        <div class="flex-center task__stat">
                            <i class="material-icons text-primary ">&#xE190;</i><b>Время выполнения до:</b>
                            {{$task->expires_at}}
                        </div>
                    </div>
                </div>
                <div class="task__image col-sm-3 col-xs-0">
                    @if(!empty($task->avatar->src))
                        <div class="task__image">
                            <img src="{{url($task->avatar->src)}}" alt="">
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-7">
                <div class="row">
                    @if(!empty($taskFiles['image']))
                        <div class="well">
                            @if(count($taskFiles['image']) > 1)
                                <div id="task-pictures" class="carousel slide clearfix" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        @foreach($taskFiles['image'] as $i =>$image)
                                            <li data-target="#task-pictures" class="{{$i == 1 ? 'active' : ''}}"
                                                data-slide-to="{{$i}}"></li>
                                        @endforeach
                                    </ol>
                                    <div class="carousel-inner" role="listbox">
                                        @foreach($taskFiles['image'] as $i=>$image)
                                            <div class="item {{$i == 1 ? 'active' : ''}}">
                                                <img src="{{url($image['src'])}}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <a class="left carousel-control" href="#task-pictures" role="button"
                                       data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                        <span class="sr-only">Предыдущий</span>
                                    </a>
                                    <a class="right carousel-control" href="#task-pictures" role="button"
                                       data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        <span class="sr-only">Следующий</span>
                                    </a>
                                </div>
                            @else
                                <div class="carousel-inner" role="listbox">
                                    <div class="item active">
                                        <img src="{{url($taskFiles['image'][0]['src'])}}">
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    @if(!empty($taskFiles['video']))
                        <div class="well">
                            <br>
                            <br>
                            @foreach($taskFiles['video'] as $index=>$video)
                                <video style="width: 100%" controls muted name="{{$video['name']}}">
                                    <source src="{{url($video['src'])}}" type="{{$video['mimetype']}}">
                                </video>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="row">
                    @include('forms.create_comment_task')
                </div>
                <div class="row">
                    @if(count($comments) > 0)
                        <div class="container">
                            <div class="row">
                                <h3>Комментарии</h3>
                                <br>
                                <br>
                                <div class="col-md-12">
                                    <div class="row">
                                        @foreach($comments as $comment)
                                            <div class="media well">
                                                <div class="media-body">
                                                    <p><h4 class="media-heading"></span>От: <b>{{$comment['author']['name']}}</b>
                                                    </h4></p>
                                                    <br>
                                                    <p>
                                                        {{$comment['description_detail']}}
                                                    </p>
                                                    @if(count($comment->getFilesByType()) > 0)
                                                        <br>
                                                        <br>
                                                        @foreach($comment->getFilesByType()->toArray() as $type=>$files)
                                                            @if($type === 'video')
                                                                @foreach($files as $file)
                                                                    <video height="320" controls muted name="{{$file['name']}}">
                                                                        <source src="{{url($file['src'])}}"
                                                                                type="{{$file['mimetype']}}">
                                                                    </video>
                                                                @endforeach
                                                            @elseif($type === 'image')
                                                                <img src="{{url($file['src'])}}" alt="" height="240">
                                                            @else
                                                                @foreach($files as $file)
                                                                    <a href="{{url($file['src'])}}">{{$file['name']}}</a>
                                                                    <br>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Дополнительная информация
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Статус:</td>
                                <td>
                                    @if(empty($task->status))
                                        Задание открыто
                                    @else
                                        {{config('task.' . $task->status)}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Постановщик:
                                </td>
                                <td>
                                    {{$creator['name']}}
                                </td>
                            </tr>
                            @if(!empty($taskFiles))
                                <tr>
                                    <td>Файлы:</td>
                                    <td>
                                        @foreach($taskFiles as $typeArr)
                                            @foreach($typeArr as $file)
                                                <a href="{{url($file['src'])}}">
                                                    {{$file['name']}}
                                                </a>
                                                <br>
                                                <br>
                                            @endforeach
                                        @endforeach
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td>
                                    @if($task->creator_id == \Auth::user()['id'])
                                        <a href="{{Request::url()}}/edit" class="btn btn-raised btn-primary">
                                            Редактировать
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if(empty($task->status) || $task->status === 'start')
                                        @if(\Auth::user()->canEditTasks())
                                            {!! Form::open(['url'=>Request::url() . '/close']) !!}
                                            <button type="submit" class="btn btn-raised btn-warning">Закрыть задание
                                            </button>
                                            {!! Form::close() !!}
                                        @else
                                            {!! Form::open(['url'=>Request::url() . '/complete']) !!}
                                            <button type="submit" class="btn btn-raised btn-warning">Задание выполнено
                                            </button>
                                            {!! Form::close() !!}
                                        @endif
                                    @elseif($task->status === 'complete')
                                        @if(\Auth::user()->canEditTasks())
                                            {!! Form::open(['url'=>Request::url() . '/close'])!!}
                                            <button type="submit" class="btn btn-raised btn-danger">Задание закрыто
                                            </button>
                                            {!! Form::close() !!}
                                        @else
                                            <a href="#" class="btn btn-raised btn-warning disabled" role="button">
                                                Задание ожидает проверки
                                            </a>
                                        @endif
                                    @elseif($task->status === 'close' && \Auth::user()->canEditTasks())
                                        {!! Form::open(['url'=>Request::url() . '/start']) !!}
                                        <button type="submit" class="btn btn-raised btn-warning">Открыть задание
                                        </button>
                                        {!! Form::close() !!}
                                    @elseif(!empty($task->status))
                                        <a href="#" class="btn btn-raised btn-danger disabled" role="button">
                                            Задание проверено
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @if(\Auth::user()->rang === 'A')
                                <tr>
                                    <td class="text-left">
                                        {!! Form::open(['url' => "/task/$task->id/delete", "method"=>"POST"]) !!}
                                        <button class="btn btn-raised btn-danger">Удалить <i
                                                    class="fa fa-trash"></i>
                                        </button>
                                        {!! Form::close() !!}
                                    </td>
                                    <td></td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>

@endsection