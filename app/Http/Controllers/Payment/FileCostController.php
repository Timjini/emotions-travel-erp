<?php

namespace App\Http\Controllers\Payment;

use App\Enums\Payment\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StoreFileCostRequest;
use App\Http\Requests\Payment\UpdateFileCostRequest;
use App\Models\Currency;
use App\Models\File;
use App\Models\FileCost;
use App\Models\Supplier;
use App\Services\ExchangeRateCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class FileCostController extends Controller
{
    /**
     * Display a listing of file costs for a specific file.
     */
    public function index(File $file)
    {
        // $this->authorize('viewAny', FileCost::class);
       
        $fileCosts = $file->costs()
            ->with(['supplier', 'fileItem', 'creator'])
            ->orderBy('service_date', 'desc')
            ->paginate(25);

        return view('file-costs.index', [
            'file' => $file,
            'costs' => $fileCosts,
            'statuses' => PaymentStatus::cases(),
        ]);
    }

    /**
     * Show the form for creating a new file cost.
     */
    public function create(File $file)
    {
        // $this->authorize('create', FileCost::class);

        return view('file-costs.create', [
            'file' => $file,
            'suppliers' => Supplier::orderBy('name')->get(),
            'statuses' => PaymentStatus::cases(),
            'currencies' => config('currencies.supported'),
        ]);
    }

    /**
     * Store a newly created file cost.
     */
    public function store(StoreFileCostRequest $request, File $file)
    {
        $validated = $request->validated();
        $baseCurrency = Currency::find($validated['base_currency_id'])->code;
        
        $calculator = app(ExchangeRateCalculator::class);
        $exchangeRate = $calculator->convertCurrency($baseCurrency, $request['original_currency']);

        // Calculate totals
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];
        $validated['converted_total'] = $validated['total_price'] * $exchangeRate;

        Log::info($validated['converted_total']);
        Log::info($validated['total_price']);

        // Set additional required fields
        $validated = array_merge($validated, [
            'customer_id' => $file->customer_id,
            'exchange_rate' => $exchangeRate,
            'converted_total' => $validated['converted_total'],
            'total_price' => $validated['total_price'],
            'original_currency_id' => $file->currency_id,
            'base_currency_id' => $validated['base_currency_id'] ?? Currency::first(),
            'created_by' => Auth::id(),
            'file_id' => $file->id,
        ]);

        // Create the cost
        $fileCost = $file->costs()->create($validated);

        return redirect()
            ->route('files.items.add', $file->id)
            ->with('success', 'File cost created successfully');
    }

    /**
     * Display the specified file cost.
     */
    public function show(File $file, FileCost $cost)
    {
        // $this->authorize('view', $cost);

        return view('file-costs.show', [
            'file' => $file,
            'cost' => $cost->load(['supplier', 'fileItem', 'creator']),
        ]);
    }

    /**
     * Show the form for editing the file cost.
     */
    public function edit(FileCost $fileCost)
    {
       return response()->json([
        'id' => $fileCost->id,
        'file_id' => $fileCost->file_id,
        'customer_id' => $fileCost->customer_id,
        'supplier_id' => $fileCost->supplier_id,
        'file_item_id' => $fileCost->file_item_id,
        'original_currency_id' => $fileCost->original_currency_id,
        'base_currency_id' => $fileCost->base_currency_id,
        'service_type' => $fileCost->service_type,
        'description' => $fileCost->description,
        'quantity' => $fileCost->quantity,
        'unit_price' => $fileCost->unit_price,
        'total_price' => $fileCost->total_price,
        'exchange_rate' => $fileCost->exchange_rate,
        'converted_total' => $fileCost->converted_total,
        'payment_status' => $fileCost->payment_status,
        'amount_paid' => $fileCost->amount_paid,
        'payment_date' => $fileCost->payment_date?->format('Y-m-d'),
        'number_of_people' => $fileCost->number_of_people,
        'quantity_anomaly' => (bool)$fileCost->quantity_anomaly,
        'service_date' => $fileCost->service_date?->format('Y-m-d'),
        'notes' => $fileCost->notes,
        'created_at' => $fileCost->created_at,
        'updated_at' => $fileCost->updated_at
    ]);
    }


public function update(UpdateFileCostRequest $request, FileCost $cost)
{
    // Debug incoming request
    Log::info('Update Request:', [
        'payload' => $request->all(),
        'route_parameters' => $request->route()->parameters(),
        'authenticated_user' => Auth::id(),
    ]);

    $validated = $request->validated();

        if (isset($validated['payment_status'])) {
            $validated['payment_status'] = PaymentStatus::from($validated['payment_status']);
        }

        $validated = array_merge($validated, [
            'customer_id' => $request->customer_id,
            'created_by' => Auth::id(),
            'file_id' => $request->file_id,
        ]);

        $cost->forceFill($validated)->save();

            
    // Debug validated data
    Log::info('Validated Data:', $validated);

    // Debug current model state
    Log::info('Current Cost State:', $cost->toArray());

    // Calculate totals
    $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];
    $validated['converted_total'] = $validated['total_price'] * ($validated['exchange_rate'] ?? 1);

    // Debug calculations
    Log::info('Calculated Values:', [
        'total_price' => $validated['total_price'],
        'converted_total' => $validated['converted_total'],
    ]);

    try {

        Log::info('Before update:', [
            'cost_id' => $cost->id,
            'exists' => $cost->exists,
            'validated' => $validated
        ]);

        $updated = $cost->update($validated);
        
        // Debug update result
        Log::info('Update Result:', [
            'success' => $updated,
            'updated_model' => $cost->toArray(),
        ]);

        if (!$updated) {
            throw new \Exception('Update operation returned false');
        }

        return redirect()
            ->route('files.items.add', $cost->file->id)
            ->with('success', 'Cost updated successfully');
            
    } catch (\Exception $e) {
        // Log the full error
        Log::error('Update Failed:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'input_data' => $request->all(),
        ]);

        return redirect()
            ->route('files.items.add', $request->file_id)
            ->with('error', 'Failed to update cost. Check logs for details.');
    }
}



    /**
     * Update the payment status of a file cost.
     */
    public function updateStatus(Request $request, File $file, FileCost $cost)
    {
        // $this->authorize('update', $cost);

        $request->validate([
            'status' => ['required', 'string', Rule::in(PaymentStatus::values())],
            'amount_paid' => ['nullable', 'numeric', 'min:0'],
            'payment_date' => ['nullable', 'date'],
        ]);

        $cost->update([
            'payment_status' => $request->status,
            'amount_paid' => $request->amount_paid ?? $cost->amount_paid,
            'payment_date' => $request->payment_date ?? ($cost->payment_date ?? now()),
        ]);

         return redirect()
            ->to("/files/{$file->id}/items")
            ->with('success', 'Cost updated successfully');
    }

    /**
     * Remove the specified file cost.
     */
    public function destroy(File $file, FileCost $cost)
    {
        // $this->authorize('delete', $cost);

        $cost->delete();

        return redirect()
            ->route('files.costs.index', $file)
            ->with('success', 'File cost deleted successfully');
    }

    /**
     * Get file costs for API requests (e.g., for select2)
     */
    public function apiIndex(File $file)
    {
        // $this->authorize('viewAny', FileCost::class);

        return $file->costs()
            ->with(['supplier', 'fileItem'])
            ->filter(request()->only('search', 'status'))
            ->orderBy('service_date', 'desc')
            ->paginate(15);
    }
}
