<div class="bs-callout well clearfix col-md-12">
    <h3>Оставить комментарий</h3>
    <br>
    {!! Form::open(['url'=>url('task/'. $task->id .'/create_comment'), 'enctype'=>'multipart/form-data']) !!}
    <div class="form-group clearfix">
        {!! Form::textarea('description_detail', null, ['class'=> 'form-control', 'rows'=>5]) !!}
    </div>
    <div class="form-group clearfix">
        {!! Form::label('files[]', 'Добавить файл', ['class'=>'btn btn-raised btn-default']) !!}
        {!! Form::input('file', 'files[]', null, ['class'=>'hidden', 'multiple'=> '']) !!}
    </div>
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif
    <div class="form-group clearfix">
        {!! Form::submit('Отправить', ['class'=>'btn btn-raised btn-primary ']) !!}
    </div>
    {!! Form::close() !!}
</div>