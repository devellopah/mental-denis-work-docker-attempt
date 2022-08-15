@extends('layouts.app')
@section('content')

    <div class="View">
        <div class="View__head">

            <div class="container">
                <div class="row text-center">

                    <div class="col-sm-5 text-sm-left">
                        <h2 class="View__title mb-sm-0">Список примеров
                        </h2>
                    </div>

                    @if(\Auth::user()['rang'] == config('rang.admin'))
                        <div class="col-sm-7 text-sm-right">
                            <div class="View__headActions">
                                <a class="View__createExercise" href="{{ route('trainers.categories.exercises.trainer_task.create', ['trainer_id' => $trainer_id, 'category_id' => $category_id, 'exercise_id' => $exercise_id]) }}">Добавить пример</a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>

        @include('common.messages')

        <div class="View__body">
            <div class="container">
                <div class="row">
                    @foreach($tasks as $task)
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="View__card">
                                <h4 class="View__cardTitle View__cardTitle--exercise">{{$task->name}}</h4>

                                <div class="View__cardActions">
                                    <a href="{{ route('trainers.categories.exercises.trainer_task.show', ['trainer_id' => $trainer_id, 'category_id' => $category_id, 'exercise_id' => $exercise_id, 'task_id' => $task->id]) }}"
                                       class="View__cardEnter">
                                        Войти
                                    </a>

                                    @if(\Auth::user()['rang'] == config('rang.admin'))
                                        <a href="{{ route('trainers.categories.exercises.trainer_task.edit', ['trainer_id' => $trainer_id, 'category_id' => $category_id, 'exercise_id' => $exercise_id, 'task_id' => $task->id]) }}"
                                           class="View__cardEdit">
                                            Редактировать
                                        </a>
                                        <button
                                                data-action="{{ route('trainers.categories.exercises.trainer_task.destroy', ['trainer_id' => $trainer_id, 'category_id' => $category_id, 'exercise_id' => $exercise_id, 'task_id' => $task->id]) }}"
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