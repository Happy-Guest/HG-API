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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:5|max:255',
            'email' => 'required|email|min:5|max:255',
            'phone' => 'nullable|numeric|digits_between:9, 12',
            'type' => 'required|in:C,O,F',
            'schedule' => 'required|string|max:255',
            'occupation' => 'required|numeric|min:0|max:999999',
            'location' => 'required|string|max:255',
            'limit' => 'required|numeric|min:0|max:999999',
            'description' => 'required|string|min:5|max:255',

        ];
    }
}
