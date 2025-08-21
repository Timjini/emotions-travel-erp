<?php

namespace App\Http\Controllers\Payment;

use App\Events\ProformaSendFailed;
use App\Events\ProformaSent;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\File;
use App\Models\Proforma;
use App\Services\FileServices\ProformaService;
use App\Services\Proformas\ProformaMailerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProformaController extends Controller
{

    protected ProformaService $service;

    public function __construct(ProformaService $service)
    {
        $this->service = $service;
    }

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
        $proforma = $this->service->createFromFile($file, $request->notes);

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
        $invoice = $this->service->convertToInvoice($proforma);

        // Mark proforma as converted
        $proforma->update(['status' => Proforma::STATUS_CONVERTED]);

        return redirect()->route('invoices.show', $invoice->id);
    }

    public function send(Proforma $proforma, ProformaMailerService $service)
    {
        // Check if proforma has items
        if ($proforma->file->items === null || $proforma->file->items->isEmpty()) {
            return redirect()->route('proformas.show', $proforma->id)
                ->with('error', 'Please add at least one item!');
        }
    
        // Check if customer email exists
        if (empty($proforma->file->customer->email)) {
            return redirect()->route('proformas.show', $proforma->id)
                ->with('error', 'Customer email is missing!');
        }
    
        try {
            // email the customer
            // $service->sendProforma($proforma, $proforma->file->customer->email);

            // // email the Admin
            // $service->sendProforma($proforma, $proforma->file->company->email);

            // // email the current User
            // $service->sendProforma($proforma, Auth::user()->email);

            
            // Dispatch success event
            ProformaSent::dispatch($proforma, Auth::user());
            
            return redirect()->route('proformas.show', $proforma->id)
                ->with('success', 'Proforma sent successfully!');
    
        } catch (\Exception $e) {
            // Dispatch failure event
            ProformaSendFailed::dispatch($proforma, Auth::user(), $e->getMessage());
            
            return redirect()->route('proformas.show', $proforma->id)
                ->with('error', 'Failed to send proforma: ' . $e->getMessage());
        }
    }
}
