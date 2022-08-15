@extends('layouts.app')
@section('content')
@if($inGroup)

	<div class="container student-dashboard">
        <div class="row student-dashboard__block">

            @if($student->group->message)

            <div class="col-xs-8">
                <h2>Групповое сообщение</h2>

                <div class="student-message">
                    {{$student->group->message}}
                </div>  
               
            </div>

            <div class="col-xs-4">
                <div class="userpic-block">
                    <div class="userpic-block__image">
                        <img src="/images/avatars/{{$student->group->user->avatar}}" alt="avatar" class="img-responsive">
                    </div>
                    <div class="userpic-block__name">{{$student->group->user->name}}</div>
                </div>
            </div>

            @endif

        </div> 

        @if($student->message)

        <div class="row student-dashboard__block">

            <div class="col-xs-8">
                <h2>Личное сообщение</h2>

                <div class="student-message">
                    {{$student->message}}
                </div> 
               
            </div>

            <div class="col-xs-4">
                <div class="userpic-block">
                    <div class="userpic-block__image">
                        <img src="/images/avatars/{{$student->group->user->avatar}}" alt="avatar" class="img-responsive">
                    </div>
                    <div class="userpic-block__name">{{$student->group->user->name}}</div>
                </div>
            </div>

        </div> 

        @endif

    </div>

@endif;
    
@endsection