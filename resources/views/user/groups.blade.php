@extends('layouts.app')
@section('content')

        <main class="pdg groups" id="app">
            <div class="container">
                <div class="block-bg">
                    <div class="block-decor block-decor--title">
                        <div class="block-decor__in">
                            <h1 class="title">Список групп</h1>
                        </div>
                    </div>
                    <div class="btns">
                        <a href="{{ route('teacher.add_student') }}" class="btn-blue icon-add" title="Добавить ученика"><span></span></a>
                    </div>
                    <div class="users-table users-table--mrg">
                        @unless($groups->count())

                            <h4>Вы ещё не создали ни одной группы</h4>

                            <div class="row">
                                <div class="col l12 s12">
                                    <a class="btn btn--sm add_group" href="{{ route('teacher.create_group') }}"><span>Добавить группу</span></a>
                                </div>
                            </div>

                            @else
                                <div class="row">
                                    <div class="col l4 m6 s12">
                                        <label>
                                            <span class="label">Группа</span>
                                            <select name="group_id" class="js-select groups_select" style="width: 100%;">
                                                <option value="all">Все ученики</option>
                                                @foreach ($groups as $key => $group)
                                                    <option value="group{{$group->id}}">{{$group->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col l12 s12 add_group text-center">
                                        <a class="btn btn--sm add_group" href="{{ route('teacher.create_group') }}"><span>Добавить группу</span></a>
                                        <a class="btn btn--sm add_group" href="{{ route('teacher.add_student') }}"><span>Добавить ученика</span></a>
                                    </div>
                                </div>

                                <div id="all" class="tab-pane active">
                                    <table class="flex-table data-table">
                                        <thead>
                                        <tr>
                                            <th>Пользователь</th>
                                            <th><div class="sort">Кол-во ответов</div></th>
                                            <th><div class="sort sort--up">Верные ответы</div></th>
                                            <th><div class="sort sort--up">Неверные ответы</div></th>
                                            <th><div class="sort sort--up">Успеваемость</div></th>
                                            <th>Рейтинг</th>
                                        </tr>
                                        </thead>
                                        <tbody class="js-scroll">
                                        @foreach($students as $student)
                                            <tr>
                                                <td>
                                                    <a href="#" data-featherlight="/images/avatars/{{$student->user->avatar}}">
                                                        <img class="student__img" src="/images/avatars/{{$student->user->avatar}}" alt="">
                                                    </a>
                                                    <a class="student__name" href="{{ route('teacher.student', ['student_id' => $student->id]) }}">{{ $student->user->name }}</a>
                                                </td>
                                                <td>{{ $student['all']['answers_total'] }}</td>
                                                <td>{{ $student['all']['answers_correct'] }}</td>
                                                <td>{{ $student['all']['answers_wrong'] }}</td>
                                                <td>{{ $student['all']['answers_accuracy'] }}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                    </table>
                                </div>
                                @foreach ($groups as $key => $group)
                                    <div id="group{{$group->id}}" class="tab-pane">
                                        @if($group->students->isEmpty())
                                            <h4>В этой группе нет еще учеников</h4>
                                        @else
                                            <table class="flex-table data-table">
                                                <thead>
                                                <tr>
                                                    <th>Пользователь</th>
                                                    <th><div class="sort">Кол-во ответов</div></th>
                                                    <th><div class="sort sort--up">Верные ответы</div></th>
                                                    <th><div class="sort sort--up">Неверные ответы</div></th>
                                                    <th><div class="sort sort--up">Успеваемость</div></th>
                                                    <th>Рейтинг</th>
                                                </tr>
                                                </thead>
                                                <tbody class="js-scroll">
                                                @foreach($group->students as $student)
                                                    <tr>
                                                        <td>
                                                            <a href="#" data-featherlight="/images/avatars/{{$student->user->avatar}}">
                                                                <img class="student__img" src="/images/avatars/{{$student->user->avatar}}" alt="">
                                                            </a>
                                                            <a class="student__name" href="{{ route('teacher.student', ['student_id' => $student->id]) }}">{{ $student->user->name }}</a>
                                                        </td>
                                                        <td>{{ $student['all']['answers_total'] }}</td>
                                                        <td>{{ $student['all']['answers_correct'] }}</td>
                                                        <td>{{ $student['all']['answers_wrong'] }}</td>
                                                        <td>{{ $student['all']['answers_accuracy'] }}</td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                            <table class="table table-striped valign-middle">
                                                <thead>
                                                <tr>
                                                    <th class="text-left">Тема</th>
                                                    <th class="text-left">Уровень</th>
                                                    <th class="text-left">ДЗ</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="text-left">{{ $group->theme }}</td>
                                                    <td class="text-left">{{ $group->level }}</td>
                                                    <td class="text-left">
                                                        <a href="{{ route('group.tasks', ['group_id' => $group->id]) }}">
                                                            <span class="group-prop-text">Настройки</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            @endif
                                            <div>
                                                <form action="{{ route('teacher.delete_group', ['group_id' => $group->id]) }}" method="post">
                                                    {{ csrf_field() }}
                                                    <button id="groupRemove" class="btn btn--sm" type="submit"><span>Удалить группу</span></button>
                                                </form>
                                            </div>
                                    </div>
                                @endforeach
                                @endunless
                    </div>
                </div>
            </div>
        </main>

        @include('common.messages')
@endsection