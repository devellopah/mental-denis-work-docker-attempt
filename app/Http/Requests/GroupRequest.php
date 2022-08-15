<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
      'name' => 'required|max:255',
      'theme' => 'required|max:255',
      'level' => 'required|max:255',
      'user_id' => 'required',
    ];
  }

  public function messages()
  {
    return [
        'name.required' => 'Поле Название группы должно быть заполнено',
        'theme.required' => 'Поле Тема должно быть заполнено',
        'level.required' => 'Поле Уровень должно быть заполнено',
        'user_id.required' => 'Не указан учитель класса',   
    ];
  }
}
