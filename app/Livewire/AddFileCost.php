<?php

namespace App\Livewire;

use App\Models\FileCost;
use App\Models\FileItem;
use App\Models\Supplier;
use Livewire\Component;

class AddFileCost extends Component
{
    public $fileItemId;

    public $fileItem;

    public $serviceType = '';

    public $description = '';

    public $quantity = 1;

    public $unitPrice = 0;

    public $originalCurrency;

    public $exchangeRate = 1;

    public $supplierId = null;

    public function mount($fileItemId)
    {
        $this->fileItemId = $fileItemId;
        $this->fileItem = FileItem::with('file')->find($fileItemId);
        $this->originalCurrency = $this->fileItem->file->currency;
    }

    public function save()
    {
        $this->validate([
            'serviceType' => 'required',
            'unitPrice' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'exchangeRate' => 'required|numeric|min:0.000001',
            'supplierId' => 'nullable|exists:suppliers,id',
        ]);

        FileCost::create([
            'file_id' => $this->fileItem->file_id,
            'customer_id' => $this->fileItem->file->customer_id,
            'file_item_id' => $this->fileItemId,
            'supplier_id' => $this->supplierId,
            'service_type' => $this->serviceType,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'unit_price' => $this->unitPrice,
            'total_price' => $this->quantity * $this->unitPrice,
            'original_currency' => $this->originalCurrency,
            'exchange_rate' => $this->exchangeRate,
            'base_currency' => 'EUR',
            'converted_total' => $this->quantity * $this->unitPrice * $this->exchangeRate,
            // 'created_by' => auth()->id()
        ]);

        $this->dispatch('costAdded');
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.add-file-cost', [
            'suppliers' => Supplier::all(),
        ]);
    }
}
