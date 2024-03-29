<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReserveRequest extends FormRequest
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
        // Update request
        if ($this->isMethod('patch')) {
            return [
                'status' => 'in:P,A,R,F,C', // P: Pending, A: Accepted, R: Rejected, F: Finished, C: Canceled
                'comment' => 'nullable|string|min:5|max:255',
            ];
        }
        // Store request
        return [
            'user_id' => 'nullable|numeric|exists:users,id',
            'user_name' => 'nullable|string|min:3|max:255',
            'nr_people' => 'required|numeric|min:1|max:999',
            'time' => 'required|dateformat:Y/m/d H:i|after_or_equal:now',
            'status' => 'nullable|in:P,A,R,F,C', // P: Pending, A: Accepted, R: Rejected, F: Finished, C: Canceled
            'service_id' => 'required|numeric|exists:services,id',
            'comment' => 'nullable|string|min:5|max:255',
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
            'time.after_or_equal' => __('validation.after_or_equal', ['attribute' => __('validation.attributes.time'), 'date' => __('validation.attributes.now')]),
        ];
    }
}
