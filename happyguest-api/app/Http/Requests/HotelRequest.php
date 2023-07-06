<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required|string|min:5|max:255',
            'phone' => 'required|numeric|digits_between:9, 12',
            'email' => 'required|email|min:5|max:255',
            'address' => 'required|string|min:5|max:255',
            'website' => 'nullable|string|min:5|max:255',
            'capacity' => 'nullable|numeric|min:1|max:999',
            'policies' => 'nullable|string|min:5|max:255',
            'access' => 'nullable|string|min:5|max:255',
        ];
    }
}
