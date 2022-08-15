@extends('layouts.app')
@section('content')

  @if( $trainer_id == 1 )
    <trainer-task></trainer-task>
  @else
    <romb-trainer></romb-trainer>
  @endif
  
@endsection
