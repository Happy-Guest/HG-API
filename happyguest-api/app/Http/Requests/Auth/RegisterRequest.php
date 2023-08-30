<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => [
                Rule::unique('users')->whereNull('deleted_at'),
                'required',
                'string',
                'email',
                'max:255',
            ],
            'password' => 'required|string|confirmed|min:5|max:255',
            'phone' => 'nullable|numeric|digits_between:9, 12',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date_format:Y/m/d|before:today|after:1900/01/01',
            'role' => 'nullable|in:C,E,M,A', // C: Client, E: Employee, M: Manager, A: Admin
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photoBase64' => 'nullable|base64image|max:2048',
        ];
    }
}
