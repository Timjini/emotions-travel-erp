<?php
namespace App\Services\FileServices;

use App\Models\FileItem;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class ItemTrackingService
{
    public function ItemAdded(FileItem $fileItem): void
    {
        if($fileItem->invoiceItem === null ||$fileItem->invoiceItem->isEmpty())
        Log::info("Creating a new Invoice Item");
        {
            InvoiceItem::create([
                'id' => Str::uuid(),
                'invoice_id' => $fileItem->id,
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
}