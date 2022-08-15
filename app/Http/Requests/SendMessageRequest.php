<?php

  namespace App\Http\Requests;

  use Illuminate\Foundation\Http\FormRequest;

  class SendMessageRequest extends FormRequest
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
        'message_text'  => 'required',
        'respondent_id' => 'required'
      ];
    }

    public function messages()
    {
      return [
        'message_text.required'=>'Необходимо ввести сообщение'
      ];
    }
  }
