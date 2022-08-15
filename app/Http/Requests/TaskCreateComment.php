<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskCreateComment extends FormRequest
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
      'description_detail' => 'required',
      'files' => 'max:10'
    ];
  }

  public function messages()
  {
    return [
      'description_detail.required' => 'Поле Текст комментария обязательно для заполнения',
      'files.max' => 'Максимальное количество файлов 10'
    ];
  }
}
