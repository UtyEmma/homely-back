<?php

namespace App\Http\Requests\Listings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
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
    public function rules(){
        return [
            'images.*' => ['required', 'image','mimes:jpeg,png,gif,webp','max:2048'],
            'title' => ['required', 'unique:App\Models\Listing,title'],
            'tenure' => ['required', 'string'],
            'rent' => ['required', 'numeric'],
            'extra_fees' => ['nullable', 'numeric'],
            'video_links' => ['nullable', 'string', 'url'],
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'landmark' => ['nullable', 'string'],
            'longitude' => ['required'],
            'latitude' => ['required'],
            'no_bedrooms' => ['required', 'numeric'],
            'no_bathrooms' => ['required', 'numeric'],
            'extra_info' => ['nullable','string'],
            'amenities' => ['nullable']
        ];
    }
}
