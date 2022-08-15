@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h3>Диалоги</h3>
            </div>
            <div class="page-body">
                @if(!empty($dialogs))
                    <table class="table table-striped valign-middle">
                        <thead>
                        <tr>
                            <th class="text-left">№</th>
                            <th class="text-left">От кого</th>
                            <th class="text-left">Последнее сообщение</th>
                            <th class="text-center" align="center">Дата</th>
                            <th class="text-center" align="center">Количество непрочитанных сообщений</th>
                        </tr>
                        </thead>
                        @foreach($dialogs as $dialog)
                            @if($dialog->respondent !== null)
                                {{$dialog->setCurrentRespondent()}}
                                <tr class="">
                                    <td align="left">{{empty($i) ? $i = 1 : $i = $i + 1}}</td>
                                    <td align="left">

                                        <a href="{{url('dialog/' . $dialog->id)}}">
                                            @if($dialog->owner->id == \Auth::user()['id'])
                                                {{optional($dialog->respondent)->name}}
                                            @else
                                                {{$dialog->owner->name}}
                                        </a>
                                        @endif
                                    </td>
                                    <td align="left">
                                        {!! $dialog->lastMessage() ? $dialog->lastMessage()->message_text : '' !!}
                                    </td>
                                    <td align="center">
                                        {{$dialog->lastMessage() ? \Carbon\Carbon::parse($dialog->lastMessage()->created_at)->format('d.m.Y') : ''}}
                                    </td>
                                    <td align="center">
                                        {{$dialog->getUnreadedMessagesCount()}}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                @else
                    У вас нет сообщений
                @endif
            </div>
        </div>
    </div>
@endsection