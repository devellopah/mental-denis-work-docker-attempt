<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'               => 'required',
            'description_short'  => 'required',
            'description_detail' => 'required',
            'starting_at'        => 'required|date',
            'expires_at'         => 'required|date|after:starting_at',
            'executor_id'        => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'               => 'Поле названия должно быть заполнено',
            'description_short.required'  => 'Поле краткое описание должно быть заполнено',
            'description_detail.required' => 'Поле детальное описание должно быть заполнено',
            'starting_at.required'        => 'Поле дата начала должно быть заполнено',
            'expires_at.required'         => 'Поле дата завершения должно быть заполнено',
            'executor_id.required'        => 'Поле исполняющий задание должно быть заполнено',
        ];
    }

    public function attributes()
    {
        return [
            'starting_at'  => 'дата начала',
            'expires_at' => 'дата завершения',
        ];
    }
}
