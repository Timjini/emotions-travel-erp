<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'destination_id' => 'required|exists:destinations,id',
            'currency_id' => 'nullable|exists:currencies,id',
        ];
    }

     public function prepareForValidation()
    {
        $this->merge([
            'currency_id' => $this->currency_code 
                ? \App\Models\Currency::where('code', strtoupper($this->currency_code))->value('id')
                : $this->currency_id,
            'is_active' => $this->has('is_active')
        ]);
    }
}
