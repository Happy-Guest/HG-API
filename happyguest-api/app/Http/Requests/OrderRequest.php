<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        return [
            'user_id' => 'required|numeric|exists:users,id',
            'room' => 'required|numeric',
            'time' => 'required|dateformat:Y/m/d H:i|after_or_equal:now',
            'status' => 'required|in:P,R,F,C', // P: Pending, R: Ready, F: Finished, C: Canceled 
            'service_id' => 'required|numeric|exists:services,id',
        ];
    }
}
