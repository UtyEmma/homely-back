<?php

namespace App\Http\Requests\Wishlist;

use Illuminate\Foundation\Http\FormRequest;

class CreateWishlistRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }


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
