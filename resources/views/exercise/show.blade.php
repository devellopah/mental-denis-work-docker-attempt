@extends('layouts.app')
@section('content')

    <div class="View">
        <div class="View__head">
            <div class="container">
                <div class="row text-center">

                    <div class="col-sm-5 text-sm-left">
                        <h2 class="View__title mb-sm-0">Список тестов, {{$exercise->name}}</h2>
                    </div>

                    @if(\Auth::user()['rang'] == config('rang.admin'))
                        <div class="col-sm-7 text-sm-right">
                            <div class="View__headActions">
                                <a class="View__createTask" href="{{url('/exercise/' . $exercise->id . '/create')}}">Добавить
                                    тест</a>
                            </div>
                        </div>
                    @endif

                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .View__head -->

        @include('common.messages')

        <div class="View__body">
            <div class="container">
                <div class="row">
                    @foreach($exercise->tasks ?? [] as $task)
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="View__card">

                                <h4 class="View__cardTitle View__cardTitle--exercise">{{$task->name}}</h4>

                                <div class="View__cardActions">
                                    <a href="{{url("/trainer_task/$task->id")}}" class="View__cardEnter">Выполнить</a>
                                    @if(\Auth::user()['rang'] == config('rang.admin'))
                                        <a href="{{url("/trainer_task/$task->id/edit")}}" class="View__cardEdit">Редактировать</a>
                                        <button
                                                data-action="/trainer_task/{{$task->id}}"
                                                class="View__cardDelete delete-btn-modal-js">
                                            Удалить
                                        </button>
                                    @endif

                                </div><!-- .View__cardActions -->
                            </div><!-- .View__card -->
                        </div><!-- .col -->
                    @endforeach
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .View__body -->
    </div><!-- .View -->

@endsection
