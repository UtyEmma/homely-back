<?php

namespace App\Http\Requests\Wishlist;

use Illuminate\Foundation\Http\FormRequest;

class CreateWishlistRequest extends FormRequest
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
            'desc' => 'required|string',
            'category' => ['required', 'string'],
            'no_bedrooms' => 'numeric',
            'no_bathrooms' => 'numeric',
            'budget' => 'required|numeric',
            'area' => 'string',
            'additional' => 'string',
            'state' => 'required',
            'city' => 'required',
            'area' => 'required'
        ];
    }
}
