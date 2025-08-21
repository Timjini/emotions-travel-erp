<?php
namespace App\Services\FileServices;

use App\Models\FileItem;
use Illuminate\Support\Facades\Log;

class FileTotalsService
{
    public function updateTotals(FileItem $fileItem): void
    {
        Log::info("File Total Service");
        $total = $fileItem->file->totalPrice();

        $proforma = $fileItem->file->proformas()->latest()->first();
        $invoice  = $proforma?->invoice;

        if ($proforma) {
            $proforma->update(['total_amount' => $total]);
        }

        if ($invoice) {
            $invoice->update(['total_amount' => $total]);
        }
    }
}