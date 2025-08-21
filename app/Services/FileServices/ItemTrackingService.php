<?php

namespace App\Services\FileServices;

use App\Models\FileItem;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ItemTrackingService
{
    public function itemAdded(FileItem $fileItem): void
    {
        if (!$fileItem->invoiceItem && $fileItem->file?->invoice) {
            Log::info("Creating InvoiceItem for FileItem {$fileItem->id}");

            InvoiceItem::create([
                'id' => Str::uuid(),
                'invoice_id' => $fileItem->file->invoice->id,
                'service_name' => $fileItem->service_name,
                'description' => $fileItem->description,
                'quantity' => $fileItem->quantity,
                'unit_price' => $fileItem->unit_price,
                'total_price' => $fileItem->total_price,
                'currency_id' => $fileItem->currency_id,
                'file_item_id' => $fileItem->id,
            ]);
        }
    }

    public function itemUpdated(FileItem $fileItem): void
    {
        $invoiceItem = $fileItem->invoiceItem;
        if ($invoiceItem) {
            Log::info("Updating InvoiceItem for FileItem {$fileItem->id}");
            $invoiceItem->update([
                'service_name' => $fileItem->service_name,
                'description' => $fileItem->description,
                'quantity' => $fileItem->quantity,
                'unit_price' => $fileItem->unit_price,
                'total_price' => $fileItem->total_price,
                'currency_id' => $fileItem->currency_id,
            ]);
        }
    }

    public function itemDeleted(FileItem $fileItem): void
    {
        $invoiceItem = $fileItem->invoiceItem;
        if ($invoiceItem) {
            Log::info("Deleting InvoiceItem for FileItem {$fileItem->id}");
            $invoiceItem->delete();
        }
    }
}
