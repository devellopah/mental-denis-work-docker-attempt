<div class="panel panel-default">
    <div class="panel-body">
        @include('common.messages')
        @include('forms.partials.text_input', ['errors' => $errors, 'name' => 'name', 'label' => 'Название'])
        @include('forms.partials.select', ['errors' => $errors, 'name' => 'category_id', 'values' => $categories, 'label' => 'Категория'])
    </div>
</div>