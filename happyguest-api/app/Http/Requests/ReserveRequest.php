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
            'user_id' => 'required|numeric|exists:users,id',
            'nr_people' => 'required|numeric|min:1|max:999',
            'time' => [
                'required',
                'dateformat:Y/m/d H:i',
                Rule::afterOrEqual(trans('validation.now')),
            ],
            'status' => 'required|in:P,R,C',
            'service_id' => 'required|numeric|exists:services,id',
        ];
    }
}
