@extends('layouts.app')
@section('content')

@component('components.student_stats', ['student' => $student, 'container' => true])

@endcomponent

@endsection
