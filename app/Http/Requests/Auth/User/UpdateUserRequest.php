<?php

namespace App\Http\Requests\Auth\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
    public function rules(){
        $user =  auth()->user();
        return [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'avatar' => 'nullable|image',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->unique_id, 'unique_id')],
            'phone' => 'nullable|numeric',
            'username' => ['required', Rule::unique('users', 'username')->ignore($user->unique_id, 'unique_id'), Rule::unique('agents', 'username')->ignore($user->unique_id, 'unique_id')]
        ];
    }
}
