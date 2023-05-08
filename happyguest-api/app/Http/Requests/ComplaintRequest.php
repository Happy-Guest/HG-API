<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintRequest extends FormRequest
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
        if ($this->isMethod('patch')) {
            return [
                'user_id' => 'numeric|exists:users,id',
                'title' => 'string|min:5|max:255',
                'status' => 'in:P,R,C',
                'comment' => 'string|max:255',
                'room' => 'numeric',
            ];
        }

        return [
            'user_id' => 'required|numeric|exists:users,id',
            'title' => 'required|string|min:5|max:255',
            'status' => 'required|in:P,R,C',
            'comment' => 'string|max:255',
            'room' => 'required|numeric',
        ];
    }
}
