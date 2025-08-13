<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Country;

class StoreDestinationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'country_id' => 'required|exists:countries,id',
            'country_name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'timezone' => 'nullable|string|max:255',
            'airport_code' => 'nullable|string|size:3',
            'currency_id' => 'nullable|exists:currencies,id',
            'visa_required' => 'nullable|boolean',
            'best_season' => 'nullable|string|max:255',
            'average_temperature' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'airport_code' => $this->airport_code ? strtoupper($this->airport_code) : null,
            'currency_id' => $this->currency_code 
                ? \App\Models\Currency::where('code', strtoupper($this->currency_code))->value('id')
                : $this->currency_id,
            'visa_required' => $this->has('visa_required'),
            'is_active' => $this->has('is_active'),
            'country_name' => $this->country_id 
                ? Country::find($this->country_id)->name 
                : null,
        ]);
    }
}