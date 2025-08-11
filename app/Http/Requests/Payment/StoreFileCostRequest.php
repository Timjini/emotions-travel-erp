<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\Payment\PaymentStatus;

class StoreFileCostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'service_type' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'original_currency' => ['required', 'string', 'size:3'],
            'exchange_rate' => ['required', 'numeric', 'min:0'],
            'payment_status' => ['required', 'string', Rule::in(PaymentStatus::values())],
            'amount_paid' => ['nullable', 'numeric', 'min:0'],
            'payment_date' => ['nullable', 'date'],
            'number_of_people' => ['nullable', 'integer', 'min:1'],
            'quantity_anomaly' => ['boolean'],
            'service_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'file_item_id' => ['nullable', 'exists:file_items,id'],
        ];
    }

    public function prepareForValidation()
    {
        if (!$this->has('quantity_anomaly')) {
            $this->merge(['quantity_anomaly' => false]);
        }
    }
}