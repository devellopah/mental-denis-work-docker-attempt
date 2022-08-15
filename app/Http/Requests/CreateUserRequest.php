<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
      'email' => 'required|email|max:255|unique:users',
      'password' => 'required|min:6|confirmed',

    ];
  }

  public function messages()
  {
    return [
      'name.required' => 'Поле Имя должно быть заполнено',
      'email.required' => 'Поле Email должно быть заполнено',
      'email.unique' => 'Данный email уже зарегистрирован',
      'password.required' => 'Поле Пароль должно быть заполнено',
      'password.confirmed' => 'Пароли должны совпадать',
      'password.min' => 'Введите более длинный пароль'

    ];
  }
}
