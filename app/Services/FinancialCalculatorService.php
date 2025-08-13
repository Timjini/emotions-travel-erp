<?php

namespace App\Services;

use App\Models\File;

class FinancialCalculatorService
{
    protected File $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    // Calculate total costs for the file
    public function totalCosts(): float
    {
        return $this->file->costs->sum('total_price');
    }

    // Calculate total billed amount (sum of file items)
    public function totalBilled(): float
    {
        return $this->file->items->sum('total_price');
    }

    // Calculate profit (billed - costs)
    public function profit(): float
    {
        return $this->totalBilled() - $this->totalCosts();
    }

    // Calculate markup percentage
    public function markup(): float
    {
        if ($this->totalCosts() === 0.0) {
            return 0;
        }

        return ($this->profit() / $this->totalCosts()) * 100;
    }

    // Calculate profit margin percentage
    public function profitMargin(): float
    {
        if ($this->totalBilled() === 0.0) {
            return 0;
        }

        return ($this->profit() / $this->totalBilled()) * 100;
    }

    // Get costs by service type
    public function costsByServiceType(): array
    {
        return $this->file->costs->groupBy('service_type')->map->sum('total_price')->toArray();
    }

    // Get payment status summary
    public function paymentStatusSummary(): array
    {
        return $this->file->costs->groupBy('payment_status')->map->count()->toArray();
    }

    // Get total paid amount
    public function totalPaid(): float
    {
        return $this->file->costs->sum('amount_paid');
    }

    // Get outstanding payments
    public function outstandingPayments(): float
    {
        return $this->totalCosts() - $this->totalPaid();
    }

    // Get comprehensive financial summary
    public function financialSummary(): array
    {
        return [
            'total_billed' => $this->totalBilled(),
            'total_costs' => $this->totalCosts(),
            'profit' => $this->profit(),
            'markup' => $this->markup(),
            'profit_margin' => $this->profitMargin(),
            'costs_by_service_type' => $this->costsByServiceType(),
            'payment_status_summary' => $this->paymentStatusSummary(),
            'total_paid' => $this->totalPaid(),
            'outstanding_payments' => $this->outstandingPayments(),
            'currency' => $this->file->currency->code ?? 'EUR',
        ];
    }
}
