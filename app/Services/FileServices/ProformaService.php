<?php
namespace App\Services\FileServices;

use App\Models\Proforma;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProformaService
{
    public function createFromFile(File $file, ?string $notes = null): Proforma
    {
        $total = $file->items->sum('total_price');

        $proformaNumber = $this->generateProformaNumber();

        return Proforma::create([
            'id' => Str::uuid(),
            'file_id' => $file->id,
            'proforma_number' => $proformaNumber,
            'issue_date' => Carbon::now()->toDateString(),
            'due_date' => Carbon::now()->addDays(7)->toDateString(),
            'total_amount' => $total,
            'currency_id' => $file->currency_id,
            'notes' => $notes,
            'status' => 'draft',
        ]);
    }

    private function generateProformaNumber(): string
    {
        return 'PF-' . Carbon::now()->format('ymdHis');
    }

    public function convertToInvoice(Proforma $proforma)
    {
        return (new InvoiceService())->createFromProforma($proforma);
    }
}
