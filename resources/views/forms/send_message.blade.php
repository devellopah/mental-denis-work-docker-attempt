<div class="panel panel-default">
    <div class="panel-heading panel-success">
        <h5>Отправить сообщение</h5>
    </div>
    <div class="panel-body">
        {!! Form::open(['class'=>'clearfix', 'url'=>url('message/send')]) !!}
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>
            @endforeach
        @endif
        <input type="hidden" value="{{$respondent_id}}" name="respondent_id">
        <div class="form-group clearfix">
            {!! Form::textarea('message_text', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group clearfix">
            {!! Form::submit('Отправить', ['class'=>'btn btn-raised btn-primary ']) !!}
        </div>

        {!! Form::close() !!}
    </div>
</div>