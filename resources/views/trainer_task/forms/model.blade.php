<div class="panel panel-default">
    <div class="panel-body">
        @include('forms.partials.text_input', ['errors' => $errors, 'name' => 'name', 'label' => 'Название'])
        {{-- @include('forms.partials.text_input', ['errors' => $errors, 'name' => 'sort', 'label' => 'Сортировка']) --}}
        {{-- @include('forms.partials.select', ['errors' => $errors, 'name' => 'exercise_id', 'values' => $categories, 'label' => 'Упражнение']) --}}
        
        @if(Route::currentRouteName() === "trainers.categories.exercises.trainer_task.create")

        {{ Form::hidden('exercise_id', $exercise_id) }}
        {{ Form::hidden('sort', $latestSort + 1) }}
        @endif

        <div class="bs-example" data-example-id="collapse-accordion">
            <div class="panel-group" role="tablist" id="accordion" aria-multiselectable="true">
                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingOne"><h4 class="panel-title"><span
                                    data-target="#collapseOne" role="button" data-toggle="collapse"
                                    data-parent="#accordion" aria-expanded="true"
                                    aria-controls="collapseOne" class="">Задать пример</span></h4>
                    </div>
                    <div class="panel-collapse collapse in" role="tabpanel" id="collapseOne"
                         aria-labelledby="headingOne" aria-expanded="true" style="">
                        <div class="panel-body">
                            @include('forms.partials.textarea',
                            ['errors' => $errors, 'name' => 'examples', 'label' => 'Пример'])
                        </div>
                    </div>
                </div>
                <div class="panel panel-danger">
                    <div class="panel-heading" role="tab" id="headingTwo"><h4 class="panel-title">
                            <span
                                    data-target="#collapseTwo" class="collapsed" role="button"
                                    data-toggle="collapse" data-parent="#accordion"
                                    aria-expanded="false" aria-controls="collapseTwo">Случайная
                                генерация </span></h4></div>
                    <div class="panel-collapse collapse" role="tabpanel" id="collapseTwo"
                         aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                        <div class="panel-body">
                            @include('forms.partials.text_input', ['errors' => $errors, 'name' => 'speed', 'label' => 'Скорость'])
                            @include('forms.partials.text_input', ['errors' => $errors, 'name' => 'count_examples', 'label' => 'Количество чисел'])
                            @include('forms.partials.text_input', ['errors' => $errors, 'name' => 'minimal_number', 'label' => 'Минимальное число'])
                            @include('forms.partials.text_input', ['errors' => $errors, 'name' => 'maximal_number', 'label' => 'Максимальное число'])
                            @if($trainer_id == 1) 
                                @include('forms.partials.checkbox', ['errors' => $errors, 'name' => 'operation',
                                'label' => 'Арифметическая операция', 'values' => ['+', '-', '*', '/']])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('common.messages')
    </div>
</div>
