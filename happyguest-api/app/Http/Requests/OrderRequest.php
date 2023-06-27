<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        // Update request
        if ($this->isMethod('patch')) {
            return [
                'status' => 'in:P,R,W,D,C', // P: Pending, R: Rejected, W: Working, D: Delivered, C: Canceled
            ];
        }
        // Store request
        return [
            'user_id' => 'required|numeric|exists:users,id',
            'room' => 'required|string|max:255',
            'time' => 'required|dateformat:Y/m/d H:i|after_or_equal:now',
            'status' => 'required|in:P,R,W,D,C', // P: Pending, R: Rejected, W: Working, D: Delivered, C: Canceled
            'service_id' => 'required|numeric|exists:services,id',
            'items' => 'required|array|min:1',
            'items.*' => 'required|numeric|exists:items,id',
            'ammount' => 'required|numeric|min:0|max:999999.99',
            'comment' => 'nullable|string|min:5|max:255',
        ];
    }
}
