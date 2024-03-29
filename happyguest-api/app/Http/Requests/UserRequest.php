<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        // Store & Update request
        return [
            'name' => 'string|min:3|max:255',
            'email' => [
                'string',
                'email',
                Rule::unique('users')->ignore($this->id, 'id')->whereNull('deleted_at'),
                'max:255',
            ],
            'phone' => 'nullable|numeric|digits_between:9, 12',
            'address' => 'nullable|string|min:5|max:255',
            'birth_date' => 'nullable|date_format:Y/m/d|before:today|after:1900/01/01',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
