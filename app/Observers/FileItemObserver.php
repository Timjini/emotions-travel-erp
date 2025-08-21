<?php

namespace App\Observers;

use App\Models\FileItem;
use Illuminate\Support\Facades\Log;

class FileItemObserver
{
    /**
     * Handle the "created" event.
     */
    public function created(FileItem $fileItem): void
    {
        Log::info("FileItemObserver created fired for FileItem {$fileItem->id}");
        
        $this->updateTotals($fileItem);
        $this->trackItemAdded($fileItem);
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(FileItem $fileItem): void
    {
        Log::info("FileItemObserver updated fired for FileItem {$fileItem->id}");
        
        $this->updateTotals($fileItem);
        $this->trackItemUpdated($fileItem);
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(FileItem $fileItem): void
    {
        Log::info("FileItemObserver deleted fired for FileItem {$fileItem->id}");
        
        $this->trackItemDeleted($fileItem);
        $this->updateTotals($fileItem);
    }

    /**
     * Update file totals using FileTotalsService.
     */
    protected function updateTotals(FileItem $fileItem): void
    {
        $fileTotals = app(\App\Services\FileServices\FileTotalsService::class);
        $fileTotals->updateTotals($fileItem);
    }

    /**
     * Track item added.
     */
    protected function trackItemAdded(FileItem $fileItem): void
    {
        $itemTracking = app(\App\Services\FileServices\ItemTrackingService::class);
        $itemTracking->itemAdded($fileItem);
    }

    /**
     * Track item updated.
     */
    protected function trackItemUpdated(FileItem $fileItem): void
    {
        $itemTracking = app(\App\Services\FileServices\ItemTrackingService::class);
        $itemTracking->itemUpdated($fileItem);
    }

    /**
     * Track item deleted.
     */
    protected function trackItemDeleted(FileItem $fileItem): void
    {
        $itemTracking = app(\App\Services\FileServices\ItemTrackingService::class);
        $itemTracking->itemDeleted($fileItem);
    }
}
