@extends('layouts.app')
@section('content')
    @if(!empty($tasks))
        <div class="container tasks__page">
            <div class="row">
                <div class="page-header">
                    <h2>Список заданий</h2>
                </div>
                @include('common.messages')
                <div class="row tasks__wrap">
                    @foreach($tasks->all() as $task)
                        <div class="col-md-6 tasks__container">
                            <div class="well clearfix">
                                <a href="{{url("/task/$task->id")}}">
                                    <h4 class="tasks__name tasks__header">{{$task->name}}</h4>
                                </a>
                                @if($task->avatar !== null)
                                    <div class="tasks__image">
                                        <img src="{{$task->avatar->src}}" alt="">
                                    </div>
                                @endif
                                <br>
                                <div class="row tasks__description">
                                    <div class="col-xs-9">
                                        <p class="text-muted">
                                            {{$task->description_short}}
                                        </p>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <br>
                                <div class="row text-small flex-center-between tasks__times__wrap">
                                    <div class="row">
                                           <span class="tasks__times">
                                            <i class="material-icons text-danger">&#xE190;</i>&nbsp;
                                               {{$task->starting_at}}
                                               -
                                               {{$task->expires_at}}
                                            </span>
                                    </div>
                                    @if($task->status)
                                        <span class="tasks__times">
                                                  <i class="text-{{config("task.classes.$task->status")}} material-icons">&#xE88E;</i>
                                                  &nbsp;
                                            {{config("task.$task->status")}}
                                                </span>
                                    @endif
                                    <div class="row text-right">
                                        <a href="{{url("task/$task->id")}}"
                                           class="pull-right btn btn-raised btn-danger btn-lg tasks__button mental-btn-1">
                                            Продолжить
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    {{$tasks->links()}}
                </div>
            </div>
        </div>
    @endif
@endsection