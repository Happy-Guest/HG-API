<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCodeRequest extends FormRequest
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
                'id' => 'required|integer|exists:user_codes,id',
                'code_id' => 'required|integer|exists:codes,id',
                'user_id' => 'required|integer|exists:users,id',
            ];
        }

        return [
            'code_id' => 'required|integer|exists:codes,id',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }
}
