<?php

namespace App\Http\Requests\Auth\Social;

use Illuminate\Foundation\Http\FormRequest;

class SocialAuthRequest extends FormRequest
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
        return [
            'given_name' => ['nullable', 'string'],
            'family_name' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'picture' => ['nullable', 'url'],
            'driver' => ['required', 'string'],
            'type' => ['required', 'string', 'in:agent,tenant']
        ];
    }
}
