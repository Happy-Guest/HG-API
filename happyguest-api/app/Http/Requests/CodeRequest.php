<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CodeRequest extends FormRequest
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
        // Update request
        if ($this->isMethod('patch')) {
            return [
                'rooms' => 'array|min:1',
                'rooms.*' => 'string|distinct|min:1|max:10',
                'entry_date' => 'date_format:Y/m/d',
                'exit_date' => 'date_format:Y/m/d|after_or_equal:entry_date',
            ];
        }
        // Create request
        return [
            'code' => [
                Rule::unique('codes')->whereNull('deleted_at'),
                'required',
                'string',
                'min:5',
                'max:255',
                'uppercase'
            ],
            'rooms' => 'required|array|min:1',
            'rooms.*' => 'required|string|distinct|min:1|max:10',
            'entry_date' => 'required|date_format:Y/m/d',
            'exit_date' => 'required|date_format:Y/m/d|after_or_equal:entry_date',
            'email' => 'nullable|email|max:255',
        ];
    }
}
