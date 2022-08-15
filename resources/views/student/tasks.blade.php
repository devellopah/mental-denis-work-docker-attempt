@extends('layouts.app')

@section('content')

    <div class="View">
        <div class="View__head">

            <div class="container">
                <div class="row text-center">

                    <div class="col-sm-5 text-sm-left">
                        <h2 class="View__title mb-sm-0">
                            Список заданий
                        </h2>
                    </div>

                    <div class="col-sm-7 text-sm-right">
      
                    </div>

                </div>
            </div>

        </div>

        <div class="View__body">

            <div class="container">

                <div class="row">

                    <div class="col-sm-4 col-md-3" style="padding-bottom: 40px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#group" class="stats-header">Групповые</a></li>
                            <li><a data-toggle="tab" href="#student" class="stats-header">Индивидуальные</a></li>
                        </ul>
                    </div>

                    <div class="col-sm-8 col-md-9">

                        <div class="tab-content" style="flex-grow: 1;">
                            <div id="group" class="tab-pane fade in active">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#group_active" class="stats-header">активные</a></li>
                                    <li><a data-toggle="tab" href="#group_finished" class="stats-header">завершённые</a></li>
                                </ul>

                                <div class="tab-content" style="flex-grow: 1;">
                                    <div id="group_active" class="tab-pane fade in active">
                                        <div class="table-overflow container-fluid">
                                            <table class="table table-striped valign-middle data-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">Старт</th>
                                                        <th class="text-left">Тренажёр</th>
                                                        <th class="text-left">Параметры</th>
                                                        <th class="text-left">Выполнение</th>
                                                        <th class="text-left">Успеваемость</th>                   
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($group_tasks_active as $task)
                                        
                                                    <tr valign="middle" class="">
                                                        <td class="text-left">
                                                            <a href="{{route('student.tasks.group_task', [
                                                            'student_id' => $student->id,
                                                            'group_task_id' => $task->id
                                                        ])}}" class="btn">Начать</a>
                                                        </td>
                                                        <td class="text-left">{{ $task->trainer_name }}</td>

                                                        @if( !is_null( json_decode($task->req_formulas) ) )
                                                        <td class="text-left">
                                                            <p>Уровень - {{ $task->level }}</p>
                                                            <p>Слагаемых - {{ $task->nums }}</p>
                                                            <p>Примеров - {{ $task->quantity }}</p>
                                                            @if( count( json_decode($task->req_formulas) ) )
                                                                <p><span>Обяз. формулы : </span></p>
                                                                @foreach (json_decode($task->req_formulas) as $formula)
                                                                    <strong>{{ $formula }}</strong>
                                                                @endforeach
                                                            @else
                                                                <p><span>Обяз. формулы - нет </span></p>
                                                            @endif
                                                            <p><span>вычитание - </span>{{ $task->subtraction ? 'да' : 'нет' }}</p>  
                                                        </td>
                                                        @else
                                                        <td class="text-left">
                                                            <p>Диапазон - {{ $task->minmax }}</p>
                                                            <p>Кол-во чисел - {{ $task->quantity }}</p>
                                                        </td>
                                                        @endif
                                                        <td class="text-left"></td>
                                                        <td class="text-left"></td>  
                                                    </tr>

                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="group_finished" class="tab-pane fade">
                                        <div class="table-overflow container-fluid">
                                            <table class="table table-striped valign-middle data-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">Старт</th>
                                                        <th class="text-left">Тренажёр</th>
                                                        <th class="text-left">Параметры</th>
                                                        <th class="text-left">Выполнение</th>
                                                        <th class="text-left">успеваемость</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($group_tasks_finished as $task)
                                                    <tr valign="middle" class="">
                                                        <td class="text-left">{{ $task->pivot->started_time }}</td>
                                                        <td class="text-left">{{ $task->trainer_name }}</td>

                                                        @if( !is_null( json_decode($task->req_formulas) ) )
                                                        <td class="text-left">
                                                            <p>Уровень - {{ $task->level }}</p>
                                                            <p>Слагаемых - {{ $task->nums }}</p>
                                                            <p>Примеров - {{ $task->quantity }}</p>
                                                            @if( count( json_decode($task->req_formulas) ) )
                                                                <p><span>Обяз. формулы : </span></p>
                                                                @foreach (json_decode($task->req_formulas) as $formula)
                                                                    <strong>{{ $formula }}</strong>
                                                                @endforeach
                                                            @else
                                                                <p><span>Обяз. формулы - нет </span></p>
                                                            @endif
                                                            <p><span>вычитание - </span>{{ $task->subtraction ? 'да' : 'нет' }}</p>  
                                                        </td>
                                                        @else
                                                        <td class="text-left">
                                                            <p>Диапазон - {{ $task->minmax }}</p>
                                                            <p>Кол-во чисел - {{ $task->quantity }}</p>
                                                        </td>
                                                        @endif
                                                        
                                                        <td class="text-left">
                                                            <p>{{$task->pivot->lead_time}}</p>
                                                            {{-- <p>Баллы: {{$task->pivot->points}}</p> --}}
                                                        </td>
                                                        <td class="text-left">{{$task->pivot->accuracy}}</td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div id="student" class="tab-pane fade">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#student_active" class="stats-header">активные</a></li>
                                    <li><a data-toggle="tab" href="#student_finished" class="stats-header">завершённые</a></li>
                                </ul>

                                <div class="tab-content" style="flex-grow: 1;">
                                    <div id="student_active" class="tab-pane fade in active">
                                        <div class="table-overflow container-fluid">
                                            <table class="table table-striped valign-middle data-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">Старт</th>
                                                        <th class="text-left">Тренажёр</th>
                                                        <th class="text-left">Параметры</th>
                                                        <th class="text-left">Выполнение</th>
                                                        <th class="text-left">Успеваемость</th>    
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($student_tasks_active as $task)
                                        
                                                    <tr valign="middle" class="">
                                                        <td class="text-left">
                                                            <a href="{{route('student.tasks.student_task', [
                                                            'student_id' => $student->id,
                                                            'student_task_id' => $task->id
                                                        ])}}" class="btn">Начать</a>
                                                        </td>
                                                        <td class="text-left">{{ $task->trainer_name }}</td>
                                                        @if( !is_null( json_decode($task->req_formulas) ) )
                                                        <td class="text-left">
                                                            <p>Уровень - {{ $task->level }}</p>
                                                            <p>Слагаемых - {{ $task->nums }}</p>
                                                            <p>Примеров - {{ $task->quantity }}</p>
                                                            @if( count( json_decode($task->req_formulas) ) )
                                                                <p><span>Обяз. формулы : </span></p>
                                                                @foreach (json_decode($task->req_formulas) as $formula)
                                                                    <strong>{{ $formula }}</strong>
                                                                @endforeach
                                                            @else
                                                                <p><span>Обяз. формулы - нет </span></p>
                                                            @endif
                                                            <p><span>вычитание - </span>{{ $task->subtraction ? 'да' : 'нет' }}</p>  
                                                        </td>
                                                        @else
                                                        <td class="text-left">
                                                            <p>Диапазон - {{ $task->minmax }}</p>
                                                            <p>Кол-во чисел - {{ $task->quantity }}</p>
                                                        </td>
                                                        @endif
                                                        <td class="text-left"></td>
                                                        <td class="text-left"></td>
                                                    </tr>

                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="student_finished" class="tab-pane fade">
                                        <div class="table-overflow container-fluid">
                                            <table class="table table-striped valign-middle data-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">Старт</th>
                                                        <th class="text-left">Тренажёр</th>
                                                        <th class="text-left">Параметры</th>
                                                        <th class="text-left">Выполнение</th>
                                                        <th class="text-left">успеваемость</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($student_tasks_finished as $task)
                                                    <tr valign="middle" class="">
                                                        <td class="text-left">{{ $task->started_time }}</td>
                                                        <td class="text-left">{{ $task->trainer_name }}</td>

                                                        @if( !is_null( json_decode($task->req_formulas) ) )
                                                        <td class="text-left">
                                                            <p>Уровень - {{ $task->level }}</p>
                                                            <p>Слагаемых - {{ $task->nums }}</p>
                                                            <p>Примеров - {{ $task->quantity }}</p>
                                                            @if( count( json_decode($task->req_formulas) ) )
                                                                <p><span>Обяз. формулы : </span></p>
                                                                @foreach (json_decode($task->req_formulas) as $formula)
                                                                    <strong>{{ $formula }}</strong>
                                                                @endforeach
                                                            @else
                                                                <p><span>Обяз. формулы - нет </span></p>
                                                            @endif
                                                            <p><span>вычитание - </span>{{ $task->subtraction ? 'да' : 'нет' }}</p>  
                                                        </td>
                                                        @else
                                                        <td class="text-left">
                                                            <p>Диапазон - {{ $task->minmax }}</p>
                                                            <p>Кол-во чисел - {{ $task->quantity }}</p>
                                                        </td>
                                                        @endif

                                                        <td class="text-left">
                                                            <p>{{$task->lead_time}}</p>
                                                            {{-- <p>Баллы: {{$task->points}}</p> --}}
                                                        </td>
                                                        <td class="text-left">{{$task->accuracy}}</td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection
