<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
        // Store request
        return [
            'user_id' => 'required|exists:users,id',
            'code_id' => 'required|exists:codes,id',
            'validated' => 'nullable|boolean',
            'date' => 'required|dateformat:Y/m/d|before_or_equal:today',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'date.before_or_equal' => __('validation.before_or_equal', ['attribute' => __('validation.attributes.date'), 'date' => __('validation.attributes.today')]),
        ];
    }
}
