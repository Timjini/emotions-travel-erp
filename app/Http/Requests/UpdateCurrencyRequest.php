<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCurrencyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => [
                'required',
                'string',
                'size:3',
                Rule::unique('currencies')->ignore($this->currency->id),
            ],
            'name' => 'required|string|max:255',
            'symbol' => 'nullable|string|max:5',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Ensure code is uppercase for consistency
        $this->merge([
            'code' => strtoupper($this->code),
        ]);
    }
}