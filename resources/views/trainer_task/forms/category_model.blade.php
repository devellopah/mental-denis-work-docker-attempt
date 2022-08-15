<div class="panel panel-default">
    <div class="panel-body">
        @include('common.messages')
        @include('forms.partials.text_input', ['errors' => $errors, 'name' => 'name', 'label' => 'Название'])
        {{ Form::hidden('trainer_id', $trainer_id) }}

    </div>
</div>
