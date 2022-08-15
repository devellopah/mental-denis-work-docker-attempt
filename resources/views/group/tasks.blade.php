@extends('layouts.app')

@section('content')

    <div id="app">

        <tasks :group-id="'{{ $group_id }}'"></tasks>

    </div>

@endsection
