@extends('layouts.app')
@section('content')
    @if(!empty($tasks))
        <div class="container tasks__page">
            <div class="row">
                <div class="page-header">
                    <h2> Список упражнения</h2>
                </div>
                @include('common.messages')
                <div class="row tasks__wrap">
                    @foreach($tasks->all() as $task)
                        <div class="col-md-6 tasks__container">
                            <div class="well clearfix">
                                <a href="{{url("/trainer_task/$task->id")}}">
                                    <h4 class="tasks__name tasks__header">{{$task->name}}</h4>
                                </a>
                                <br>
                                <div class="row tasks__description">

                                </div>
                                <div class="row text-small flex-center-between tasks__times__wrap">s
                                    <div class="row">
                                           <span class="tasks__times">
                                            <i class="material-icons text-danger">&#xE190;</i>&nbsp;
                                            </span>
                                    </div>
                                    <div class="row text-right">
                                        <a href="{{url("/trainer_task/$task->id")}}"
                                           class="pull-right btn btn-raised btn-danger btn-lg tasks__button">
                                            Выполнить
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