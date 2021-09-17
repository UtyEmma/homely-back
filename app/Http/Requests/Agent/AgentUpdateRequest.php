<?php

namespace App\Http\Requests\Agent;

use Illuminate\Foundation\Http\FormRequest;

class AgentUpdateRequest extends FormRequest
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
            'email' => 'required|string|email',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'username' => 'nullable|string',
            'avatar' => 'nullable|file',
            'email' => 'required|email|string',
            'location' => 'nullable|string',
            'phone_number' => 'nullable|numeric|digits:11',
            'whatsapp_no' => 'nullable|numeric|digits:11',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'website' => 'nullable|url',
            'twitter' => 'nullable|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'bio' => 'nullable|string',
            'title' => 'required|string'
        ];
    }
}
