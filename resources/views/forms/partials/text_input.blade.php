<div class="form-group clearfix {{$errors->has($name) ? 'has-error' : ''}}">
    {!! Form::label($name,$label, ['class'=>'col-md-4']) !!}
    <div class="col-md-6">
        {!! Form::text($name, old($name), ['class'=> 'form-control']) !!}
        @if($errors->has($name))
            <br>
            <br>
            <span class="alert alert-danger">

                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>