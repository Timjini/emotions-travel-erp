<?php

namespace App\Http\Requests\Payment;

use App\Enums\Payment\PaymentStatus;
use Illuminate\Validation\Rule;

class UpdateFileCostRequest extends StoreFileCostRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file_id' => ['required', 'exists:files,id'],
            'service_type' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'original_currency' => ['required', 'string', 'size:3', 'exists:currencies,code'],
            'exchange_rate' => ['required', 'numeric', 'min:0'],
            'base_currency' => ['required', 'string', 'size:3', 'exists:currencies,code'],
            'payment_status' => ['required', 'string', Rule::in(PaymentStatus::values())],
            'amount_paid' => [
                'nullable',
                'numeric',
                'min:0',
                Rule::requiredIf(function () {
                    return in_array($this->payment_status, ['partially_paid', 'paid']);
                }),
            ],
            'payment_date' => [
                'nullable',
                'date',
                Rule::requiredIf($this->payment_status === 'paid'),
            ],
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
        $file = File::find($this->file_id);

        $this->merge([
            'quantity_anomaly' => $this->boolean('quantity_anomaly'),
            'base_currency' => $this->base_currency ?? config('app.currency', 'EUR'),
            'customer_id' => $file->customer_id,
            'amount_paid' => $this->payment_status === 'pending' ? 0 : ($this->amount_paid ?? 0),
            'payment_date' => $this->payment_status !== 'paid' ? null : $this->payment_date,
            'exchange_rate' => $this->exchange_rate ?? 1,
        ]);
    }
}
