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
        if ($this->request->get('device') == 'mobile') {
            return [
                'data.*.name' => 'required|string|min:3|max:255',
                'data.*.email' => [
                    Rule::unique('users')->whereNull('deleted_at'),
                    'required',
                    'string',
                    'email',
                    'max:255',
                ],
                'data.*.password' => 'required|string|confirmed|min:5|max:255',
                'data.*.phone' => 'nullable|numeric|digits_between:9, 12',
                'data.*.role' => 'nullable|in:C,M,A', // C: Client, M: Manager, A: Admin
                'data.*.photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        }

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
            'role' => 'nullable|in:C,M,A', // C: Client, M: Manager, A: Admin
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
