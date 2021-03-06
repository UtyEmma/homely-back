<?php

namespace App\Http\Requests\Agent;

use Illuminate\Foundation\Http\FormRequest;

class SignupAgentRequest extends FormRequest
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
            'email' => 'required|email|unique:agents,email',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'password' => 'required|min:6',
            'username' => 'unique:agents,username|between:3,12'
        ];
    }
}
