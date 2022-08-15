<div class="clearfix">
    @if(!empty($messages))
        @foreach($messages as $id => $message)
            <div class="label label-{{$message['code']}}">{{$message['text']}}</div>
        @endforeach
        <br>
        <br>
    @endif
</div>