<?php

namespace App\Http\Requests\Payment;

use App\Enums\Payment\PaymentStatus;
use App\Models\Currency;
use App\Models\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;


class UpdateFileCostRequest extends StoreFileCostRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $cost = $this->route('cost');
        $file = $cost?->file;

        $prepared = [
            'unit_price' => $this->unit_price,
            'quantity_anomaly' => $this->boolean('quantity_anomaly'),
            'customer_id' => $this->customer_id,
            'amount_paid' => $this->amount_paid ?? 0,
            'payment_date' => $this->payment_date,
            'exchange_rate' => $this->exchange_rate ?? 1,
            'original_currency_id' => $this->original_currency_id ?? $file?->currency_id,
            'base_currency_id' => $this->base_currency_id ?? Currency::first()->id,
        ];

        // Log what is being prepared before validation
        Log::info('PrepareForValidation:', [
            'route_cost_id' => $cost?->id,
            'file_id' => $file?->id,
            'prepared_data' => $prepared,
        ]);

        $this->merge($prepared);
    }

    public function rules()
    {
        $rules = [
            'file_id' => ['required', 'exists:files,id'],
            'service_type' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'original_currency_id' => 'required|exists:currencies,id',
            'base_currency_id' => 'required|exists:currencies,id',
            'exchange_rate' => 'required|numeric|min:0',
            'payment_status' => ['required', 'string', Rule::in(PaymentStatus::values())],
            'amount_paid' => [
                'nullable',
                'numeric',
                'min:0',
                Rule::requiredIf(fn() => in_array($this->payment_status, ['partially_paid', 'paid', 'fully_paid'])),
            ],
            'payment_date' => [
                'nullable',
                'date',
                Rule::requiredIf(fn() => in_array($this->payment_status, ['paid', 'fully_paid'])),
            ],
            'number_of_people' => ['nullable', 'integer', 'min:1'],
            'quantity_anomaly' => ['boolean'],
            'service_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'file_item_id' => ['nullable', 'exists:file_items,id'],
        ];

        // Log the rules being applied
        Log::info('Validation Rules:', ['rules' => $rules]);

        return $rules;
    }
}
