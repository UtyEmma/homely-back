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
            // 'category' => 'required|string',
            // 'no_rooms' => 'numeric',
            // 'features' => 'required',
            // 'amenities' => 'required',
            // 'budget' => 'numeric',
            // 'state' => 'string',
            // 'lga' => 'string',
            // 'area' => 'string',
            // 'additional' => 'string'
        ];
    }
}
