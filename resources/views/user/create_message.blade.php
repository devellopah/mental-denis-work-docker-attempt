@extends('layouts.app')
@section('content')
    <div class="page-header">
        <h2>{{config('rang.' . \Auth::user()->rang)}}: {{$user->name}}</h2>
    </div>
    @include('forms.send_message')
@endsection