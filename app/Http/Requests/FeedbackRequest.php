<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
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
     * Get the validation rules that apply to the contact form request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name' => 'required|max:60',
          'email' => 'required|email',
          'user_message' => 'required|min:10',
        ];
    }
}
