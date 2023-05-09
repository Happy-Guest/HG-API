<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        if ($this->isMethod('patch')) {
            return [
                'rooms' => 'array|min:1',
                'rooms.*' => 'string|distinct',
                'entry_date' => 'date_format:Y/m/d H:i:s|before:exit_date',
                'exit_date' => 'date_format:Y/m/d H:i:s|after:entry_date',
            ];
        }

        return [
            'code' => 'required|string|max:255',
            'rooms' => 'required|array|min:1',
            'rooms.*' => 'required|string|distinct',
            'entry_date' => 'required|date_format:Y/m/d H:i:s|before:exit_date',
            'exit_date' => 'required|date_format:Y/m/d H:i:s|after:entry_date',
        ];
    }
}
