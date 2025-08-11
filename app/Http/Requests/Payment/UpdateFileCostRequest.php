<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\Payment\PaymentStatus;

class UpdateFileCostRequest extends StoreFileCostRequest
{
    public function rules()
    {
        return array_merge(parent::rules(), [
            // Add any additional rules for update if needed
        ]);
    }
}