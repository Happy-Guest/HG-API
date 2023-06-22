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
                'response' => 'nullable|string|max:255',
                'status' => 'in:P,S,R,C', // P: Pending, S: Solving, R: Resolved, C: Canceled
            ];
        }

        return [
            'user_id' => 'nullable|numeric|exists:users,id',
            'title' => 'required|string|min:5|max:255',
            'date' => 'required|dateformat:Y/m/d|before_or_equal:today',
            'local' => 'required|string|min:5|max:255',
            'status' => 'required|in:P,S,R,C', // P: Pending, S: Solving, R: Resolved, C: Canceled
            'files' => 'nullable|array|max:10',
            'files.*' => 'required|file|mimes:pdf,png,jpg,svg,jpeg|max:10240', // 10MB
            'comment' => 'required|string|min:5|max:255',
        ];
    }
}
