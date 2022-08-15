<div class="form-group clearfix {{$errors->has($name) ? 'has-error' : ''}}">
    {!! Form::label($name,$label, ['class'=>'col-md-4']) !!}
    <div class="col-md-6">
        @foreach($values as $value)
            <label class="checkbox">
                {!! Form::checkbox($name . '[]', $value, null, []) !!}
                <span class="checkbox-material"><span class="check"></span></span>
                <b>&nbsp;{{$value}}</b>
            </label>
        @endforeach
        @if($errors->has($name))
            <br>
            <br>
            <span class="alert alert-danger">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>