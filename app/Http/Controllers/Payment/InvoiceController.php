<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\File;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Proforma;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    /**
     * Display all invoices
     */
    public function index(Request $request): View
    {
        $invoices = Invoice::with(['file', 'proforma', 'currency'])
            ->latest()
            ->paginate(10);

        return view('invoices.index', [
            'invoices' => $invoices,
        ]);
    }

    /**
     * Show the form for creating a new invoice
     */
    public function create(Request $request, $fileId): View
    {
        $file = File::with(['items', 'customer', 'currency'])->findOrFail($fileId);
        $proformas = Proforma::where('file_id', $fileId)->get();
        $currencies = Currency::all();

        return view('invoices.create', [
            'file' => $file,
            'proformas' => $proformas,
            'currencies' => $currencies,
        ]);
    }

    /**
     * Store a newly created invoice
     */
    public function store(Request $request, $fileId): RedirectResponse
    {
        $file = File::with('items')->findOrFail($fileId);

        // Generate invoice number
        $lastNumber = Invoice::max('invoice_number');
        $nextNumber = $lastNumber ? intval(substr($lastNumber, -3)) + 1 : 1;
        $invoiceNumber = 'INV-'.Carbon::now()->year.'-'.str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Create the invoice
        $invoice = Invoice::create([
            'id' => Str::uuid(),
            'file_id' => $file->id,
            'proforma_id' => $request->input('proforma_id'),
            'invoice_number' => $invoiceNumber,
            'issue_date' => Carbon::now()->toDateString(),
            'due_date' => $request->input('due_date') ?? Carbon::now()->addDays(30)->toDateString(),
            'total_amount' => $file->items->sum('total_price'),
            'currency_id' => $request->input('currency_id') ?? $file->currency_id,
            'status' => 'unpaid',
            'notes' => $request->input('notes'),
        ]);

        // Create invoice items from file items
        foreach ($file->items as $item) {
            InvoiceItem::create([
                'id' => Str::uuid(),
                'invoice_id' => $invoice->id,
                'service_name' => $item->service_name,
                'description' => $item->description,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'total_price' => $item->total_price,
                'currency_id' => $item->currency_id,
            ]);
        }

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified invoice
     */
    public function show($id): View
    {
        $invoice = Invoice::with(['file', 'proforma', 'currency', 'items', 'items.currency'])
            ->findOrFail($id);

        return view('invoices.show', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * Show the form for editing the invoice
     */
    public function edit($id): View
    {
        $invoice = Invoice::with(['file', 'items'])->findOrFail($id);
        $currencies = Currency::all();
        $statuses = ['unpaid', 'paid', 'cancelled', 'refunded'];

        return view('invoices.edit', [
            'invoice' => $invoice,
            'currencies' => $currencies,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Update the specified invoice
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $invoice = Invoice::findOrFail($id);

        $validated = $request->validate([
            'due_date' => 'nullable|date',
            'currency_id' => 'nullable|exists:currencies,id',
            'status' => 'required|in:unpaid,paid,cancelled,refunded',
            'notes' => 'nullable|string',
        ]);

        $invoice->update($validated);

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified invoice
     */
    public function destroy($id): RedirectResponse
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    /**
     * Update invoice item
     */
    public function updateItem(Request $request, $invoiceId, $itemId): RedirectResponse
    {
        $item = InvoiceItem::where('invoice_id', $invoiceId)
            ->findOrFail($itemId);

        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'currency_id' => 'nullable|exists:currencies,id',
        ]);

        // Calculate new total price
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];

        $item->update($validated);

        // Update invoice total
        $this->updateInvoiceTotal($invoiceId);

        return back()->with('success', 'Item updated successfully.');
    }

    /**
     * Delete invoice item
     */
    public function destroyItem($invoiceId, $itemId): RedirectResponse
    {
        $item = InvoiceItem::where('invoice_id', $invoiceId)
            ->findOrFail($itemId);
        $item->delete();

        // Update invoice total
        $this->updateInvoiceTotal($invoiceId);

        return back()->with('success', 'Item deleted successfully.');
    }

    /**
     * Add new item to invoice
     */
    public function storeItem(Request $request, $invoiceId): RedirectResponse
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'currency_id' => 'nullable|exists:currencies,id',
        ]);

        // Calculate total price
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];
        $validated['invoice_id'] = $invoiceId;
        $validated['id'] = Str::uuid();

        InvoiceItem::create($validated);

        // Update invoice total
        $this->updateInvoiceTotal($invoiceId);

        return back()->with('success', 'Item added successfully.');
    }

    /**
     * Recalculate invoice total amount
     */
    private function updateInvoiceTotal($invoiceId): void
    {
        $total = InvoiceItem::where('invoice_id', $invoiceId)
            ->sum('total_price');

        Invoice::where('id', $invoiceId)
            ->update(['total_amount' => $total]);
    }

    public function downloadPdf($id)
    {
        $invoice = Invoice::with(['file', 'file.customer', 'currency', 'items', 'items.currency'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        // return $pdf->download('invoice-'.$invoice->invoice_number.'.pdf');
        return $pdf->stream('invoice-'.$invoice->invoice_number.'.pdf');
    }
}
