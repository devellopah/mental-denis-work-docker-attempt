@extends('layouts.app')
@section('content')
    <group-task 
        :task="'{{ rawurlencode(json_encode( $task )) }}'"
        :trainer_id="{{ json_encode($trainer_id) }}"
        :trainer_name="{{ json_encode($trainer_name) }}"
        :student_id="{{json_encode($student_id)}}"
        :task_type="{{json_encode($task_type)}}"
    ></group-task>
@endsection
