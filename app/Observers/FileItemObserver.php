<?php

namespace App\Observers;

use App\Models\FileItem;
use App\Services\FileServices\FileTotalsService;
use App\Services\FileServices\ItemTrackingService;
use Illuminate\Support\Facades\Log;

class FileItemObserver
{
    protected FileTotalsService $fileTotals;
    protected ItemTrackingService $itemTracking;

    public function __construct(FileTotalsService $fileTotals, ItemTrackingService $itemTracking)
    {
        $this->fileTotals = $fileTotals;
        $this->itemTracking = $itemTracking;
    }

    protected function handle(FileItem $fileItem): void
    {
        $this->fileTotals->updateTotals($fileItem);
    }
    protected function trackItem(FileItem $fileItem): void
    {
        $this->itemTracking->ItemAdded($fileItem);
    }

    public function created(FileItem $fileItem): void
    {
        $this->handle($fileItem);
    }

    public function updated(FileItem $fileItem): void
    {
        $this->handle($fileItem);
    }

    public function deleted(FileItem $fileItem): void
    {
        // $invoice
    }
}
