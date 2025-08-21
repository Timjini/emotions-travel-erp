<?php

namespace App\Observers;

use App\Models\FileItem;
use App\Services\FileServices\FileTotalsService;
use Illuminate\Support\Facades\Log;

class FileItemObserver
{
    protected FileTotalsService $fileTotals;

    public function __construct(FileTotalsService $fileTotals)
    {
        $this->fileTotals = $fileTotals;
    }

    protected function handle(FileItem $fileItem): void
    {
        $this->fileTotals->updateTotals($fileItem);
    }

    public function created(FileItem $fileItem): void
    {
        Log::info("new item created");
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
