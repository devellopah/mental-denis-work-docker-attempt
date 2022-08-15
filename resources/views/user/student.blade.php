@extends('layouts.app')

@section('content')

    <main class="pdg" id="app">
        <div class="container">
            <div class="acc block-bg">
                <div class="user-photo">
                    <a href="#" data-featherlight="/images/avatars/{{$student->user->avatar}}">
                        <img src="/images/avatars/{{$student->user->avatar}}" alt="">
                    </a>
                </div>
                <div class="acc__btns btns">
                    <form action="{{ route('teacher.remove_student', ['student_id' => $student->id]) }}" method="post">
                        {{ csrf_field() }}
                        <a href="{{ url('/users') }}" class="btn-blue icon-arrow-back"><span></span></a>
                        <a href="{{ url('/teacher/groups') }}" class="btn-blue"><span></span><b>Мои ученики</b></a>
                        <button id="studentRemove" type="submit" class="btn-blue icon-del" title="Удалить из группы"><span></span></button>
                    </form>
                </div>
                <div class="acc__top">
                    <div class="acc__top-left">
                        <div class="acc__points">
                            <span>Баллов</span>
                            81 443.7
                        </div>
                    </div>
                </div>
                @include('common.messages')
                {!! Form::open(array('url' => route('teacher.update_student', ['student_id' => $student->id]))) !!}
                {{ csrf_field() }}
                @include('common.messages')
                <div class="row">
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Имя</span>
                            <input id="name" type="text" class="field" name="name" value="{{$student->user->name}}" readonly>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">E-mail</span>
                            <input id="name" type="text" class="field" name="name" value="{{$student->user->email}}" readonly>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Заметка об ученике</span>
                            <input id="name" type="text" class="field" name="note" value="{{$student->note}}" autofocus>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Сообщение ученику</span>
                            <textarea class="field" name="message" spellcheck="false">{{$student->message}}</textarea>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Группа</span>
                            <select name="group_id" id="userGroupSelect" data-url="{{ route('teacher.update_student', ['student_id' => $student->id]) }}" class="js-select" style="width: 100%;">
                                <option value="{{$student->group->id}}">{{$student->group->name}}</option>
                                @foreach ($groups as $group)
                                    <option value="{{$group->id}}">{{$group->name}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <input type="hidden" name="student_id" value="{{$student->id}}">
                    <div class="col l12 s12">
                        <button type="submit" name="button" class="btn">
                            <span>Сохранить</span>
                        </button>
                    </div>
                    <div class="col l12 s12">
                        @component('components.student_stats', ['student' => $student, 'container' => true])
                        @endcomponent
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </main>

@endsection