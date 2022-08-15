@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-header">
            <h3>Диалог: {{$respondent->name}}</h3>
        </div>
        @include('forms.send_message')

        @if(!empty($dialogMessages))
            <div class="list-group clearfix chat-page">
                @foreach($dialogMessages as $message)
                    <div class="list-group-item well {{$message->belongToAuthUser() ? '' : 'active'}}">
                        <h5><b>{{$message->author->name}}</b></h5>
                        <br>
                        {!! $message->message_text !!}
                    </div>
                @endforeach
            </div>
            {{$dialogMessages->links()}}
        @endif
    </div>
@endsection