<?php

namespace App\Http\Requests\Auth\Social;

use Illuminate\Foundation\Http\FormRequest;

use function PHPUnit\Framework\returnArgument;

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
    public function rules()
    {
        return [
            'data.given_name' => ['required', 'string'],
            'data.family_name' => ['required', 'string'],
            'data.email' => ['required', 'email'],
            'data.picture' => ['required', 'url'],
            'driver' => ['required', 'string'],
            'type' => ['string', 'in:agent,tenant']
        ];
    }
}
