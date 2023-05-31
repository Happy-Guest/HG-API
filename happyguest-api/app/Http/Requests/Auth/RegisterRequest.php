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
            $this->request->get('name') => 'required|string|min:3|max:255',
            $this->request->get('email') => [
                Rule::unique('users')->whereNull('deleted_at'),
                'required',
                'string',
                'email',
                'max:255',
            ],
            $this->request->get('password') => 'required|string|confirmed|min:5|max:255',
            $this->request->get('phone') => 'nullable|numeric|digits_between:9, 12',
            $this->request->get('role') => 'nullable|in:C,M,A', // C: Client, M: Manager, A: Admin
            $this->request->get('photo') => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
