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
                'status' => 'in:P,A,R,C', // P: Pending, A: Accepted, R: Rejected, C: Canceled
            ];
        }
        // Store request
        return [
            'user_id' => 'required|numeric|exists:users,id',
            'nr_people' => 'required|numeric|min:1|max:999',
            'time' => 'required|dateformat:Y/m/d H:i|after_or_equal:now',
            'status' => 'required|in:P,A,R,C', // P: Pending, A: Accepted, R: Rejected, C: Canceled
            'service_id' => 'required|numeric|exists:services,id',
            'comment' => 'nullable|string|min:5|max:255',
        ];
    }
}
