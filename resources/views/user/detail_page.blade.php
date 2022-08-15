@extends('layouts.app')

@section('content')

    <main class="pdg" id="app">
        <div class="container">
            <div class="acc block-bg">
                <div class="user-photo">
                    <a href="#" data-featherlight="/images/avatars/{{$user->avatar}}">
                        <img src="/images/avatars/{{$user->avatar}}" alt="">
                    </a>
                </div>
                <div class="acc__btns btns">
                    <a href="{{ url('/users') }}" class="btn-blue icon-arrow-back"><span></span></a>
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
                {!! Form::open(array('url' => route('teacher.update_student', ['student_id' => $user->id]))) !!}
                {{ csrf_field() }}
                @include('common.messages')
                <div class="row">
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Имя</span>
                            <input id="name" type="text" class="field" name="name" value="{{$user->name}}" readonly>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">E-mail</span>
                            <input id="name" type="text" class="field" name="name" value="{{$user->email}}" readonly>
                        </label>
                    </div>
                    <div class="col l12 s12">
                        @if($showStats)
                            @component('components.student_stats', ['student' => $student, 'container' => true])
                            @endcomponent
                        @endif
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </main>
