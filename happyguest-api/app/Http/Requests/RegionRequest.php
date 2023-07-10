<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegionRequest extends FormRequest
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
            'description' => 'required|string|min:5|max:255',
            'descriptionEN' => 'required|string|min:5|max:255',
            'proximities' => 'nullable|array|min:1',
            'activities' => 'nullable|array|min:1',
            'websites' => 'nullable|array|min:1',
        ];
    }
}
