<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'number_of_people' => 'required|integer|min:1',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'program_id'       => 'nullable|exists:programs,id',
            'destination_id'   => 'nullable|exists:destinations,id',
            'currency_id'      => 'nullable|exists:currencies,id',
            'guide'            => 'nullable|string|max:255',
            'note'             => 'nullable|string',
            'status'           => ['required', 'string', Rule::in(['pending', 'confirmed', 'cancelled'])],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->status ?? 'pending',
        ]);
    }
}
