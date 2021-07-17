<?php

namespace App\Http\Requests\Listings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateListingRequest extends FormRequest
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
            'images.*' => ['image','mimes:jpeg,png,gif,webp','max:2048'],
            'title' => ['required', 'unique:agents,title,except,id'],
            'email' => Rule::unique('listings', 'title')->where(function ($query) {
                return $query->where('agent_id', auth()->user()->unique_id);
            })
        ];
    }
}
