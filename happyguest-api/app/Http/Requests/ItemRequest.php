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
                'name' => 'string|min:5|max:255',
                'nameEN' => 'string|min:5|max:255',
                'price' => 'nullable|numeric|min:0|max:999999.99',
                'category' => 'in:room,bathroom,drink,breakfast,lunch,dinner,snack,dessert,other',
                'stock' => 'nullable|numeric|min:0|max:999999',
            ];
        }
        // Store request
        return [
            'name' => 'required|string|min:5|max:255',
            'nameEN' => 'required|string|min:5|max:255',
            'price' => 'nullable|numeric|min:0|max:999999.99',
            'type' => 'required|in:O,F', // O - Object, F - Food
            'category' => 'required|in:room,bathroom,drink,breakfast,lunch,dinner,snack,dessert,other',
            'stock' => 'nullable|numeric|min:0|max:999999',
        ];
    }
}
