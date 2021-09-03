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
            'avatar' => 'file',
            'email' => 'required|email|string',
            'location' => 'string',
            'phone_number' => 'numeric|digits:11',
            'whatsapp_no' => 'numeric|digits:11',
            'state' => 'string',
            'city' => 'string',
            'website' => 'url',
            'twitter' => 'string',
            'facebook' => 'string',
            'instagram' => 'string',
            'bio' => 'string',
            'title' => 'string'
        ];
    }
}
