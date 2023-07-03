<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
        // Update request
        if ($this->isMethod('patch')) {
            return [
                'email' => 'nullable|email|min:5|max:255',
                'phone' => 'nullable|numeric|digits_between:9, 12',
                'schedule' => 'string|max:255',
                'occupation' => 'nullable|numeric|min:0|max:999999',
                'location' => 'nullable|string|max:255',
                'limit' => 'nullable|numeric|min:0|max:999999',
                'description' => 'string|min:5|max:255',
                'descriptionEN' => 'string|min:5|max:255',
                'menu' => 'nullable|file|mimes:pdf|max:10240',
            ];
        }
        // Store request
        return [
            'name' => 'required|string|min:5|max:255',
            'nameEN' => 'nullable|string|min:5|max:255',
            'email' => 'nullable|email|min:5|max:255',
            'phone' => 'nullable|numeric|digits_between:9, 12',
            'type' => 'required|in:C,O,F,R', // C - Cleaning, B - Object, F - Food, R - Restaurant, O - Other
            'schedule' => 'required|string|max:255',
            'occupation' => 'nullable|numeric|min:0|max:999999',
            'location' => 'nullable|string|max:255',
            'limit' => 'nullable|numeric|min:0|max:999999',
            'description' => 'required|string|min:5|max:255',
            'descriptionEN' => 'nullable|string|min:5|max:255',
            'menu' => 'nullable|file|mimes:pdf|max:10240',
        ];
    }
}
