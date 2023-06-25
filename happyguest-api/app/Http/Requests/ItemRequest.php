<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:5|max:255',
            'price' => 'required|numeric|min:0|max:999999.99',
            'type' => 'required|in:O,F',
            'category' => 'required|in:room,bathroom',
            'amount_stock' => 'required|numeric|min:0|max:999999',
        ];
    }
}
