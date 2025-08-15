<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\File;
use App\Models\Invoice;
use App\Models\Proforma;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProformaController extends Controller
{
    public function index()
    {
        $proformas = Proforma::with(['file', 'currency'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('proformas.index', compact('proformas'));
    }

    public function store(Request $request, $fileId)
    {
        $file = File::with('items')->findOrFail($fileId);

        // Calculate total
        $total = $file->items->sum('total_price');

        // Generate proforma number
        $lastNumber = Proforma::max('proforma_number');
        $nextNumber = $lastNumber ? intval(substr($lastNumber, -3)) + 1 : 1;
        $latest = Proforma::whereYear('created_at', Carbon::now()->year)
            ->orderByDesc('proforma_number')
            ->first();

        if ($latest) {
            // Extract numeric part from last proforma_number (e.g., "PF-2025-003" → 3)
            $lastNumber = (int) Str::afterLast($latest->proforma_number, '-');
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $proformaNumber = 'PF-' . Carbon::now()->format('ymdHis');



        $proforma = Proforma::create([
            'id' => Str::uuid(),
            'file_id' => $file->id,
            'proforma_number' => $proformaNumber,
            'issue_date' => Carbon::now()->toDateString(),
            'due_date' => Carbon::now()->addDays(7)->toDateString(),
            'total_amount' => $total,
            'currency_id' => $file->currency_id,
            'notes' => $request->input('notes'),
            'status' => 'draft',
        ]);

        return redirect()->route('proformas.show', $proforma->id)
            ->with('success', 'Proforma created successfully.');
    }

    public function show($id)
    {
        $proforma = Proforma::with(['file', 'file.items', 'currency'])->findOrFail($id);

        return view('proformas.show', compact('proforma'));
    }

    public function edit($id)
    {
        $proforma = Proforma::findOrFail($id);
        $currencies = Currency::all();
        $statuses = ['draft', 'sent', 'paid', 'cancelled'];

        return view('proformas.edit', compact('proforma', 'currencies', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $proforma = Proforma::findOrFail($id);

        $validated = $request->validate([
            'due_date' => 'nullable|date',
            'currency_id' => 'nullable|exists:currencies,id',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,sent,paid,cancelled',
        ]);

        $proforma->update($validated);

        return redirect()->route('proformas.show', $proforma->id)
            ->with('success', 'Proforma updated successfully.');
    }

    public function destroy($id)
    {
        $proforma = Proforma::findOrFail($id);
        $proforma->delete();

        return redirect()->route('proformas.index')
            ->with('success', 'Proforma deleted successfully.');
    }

    // this should be a service

    public function convertToInvoice($proformaId)
    {
        $proforma = Proforma::with(['file.items'])->findOrFail($proformaId);

        // Generate invoice number (different series)
        $lastNumber = Invoice::max('invoice_number');
        $nextNumber = $lastNumber ? intval(substr($lastNumber, -3)) + 1 : 1;
        $invoiceNumber = 'INV-' . Carbon::now()->toDateTimeString() . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $invoice = Invoice::create([
            'file_id' => $proforma->file_id,
            'proforma_id' => $proforma->id,
            'invoice_number' => $invoiceNumber,
            'issue_date' => now()->toDateString(),
            'due_date' => now()->addDays(14)->toDateString(),
            'total_amount' => $proforma->total_amount,
            'currency_id' => $proforma->currency_id,
            'status' => 'unpaid',
        ]);

        // Optionally: copy file items into invoice_items table
        foreach ($proforma->file->items as $item) {
            $invoice->items()->create([
                'service_name' => $item->service_name,
                'description' => $item->description,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'total_price' => $item->total_price,
                'currency_id' => $item->currency_id,
            ]);
        }

        // Mark proforma as converted
        $proforma->update(['status' => Proforma::STATUS_CONVERTED]);

        return redirect()->route('invoices.show', $invoice->id);
    }
}
