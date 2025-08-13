<?php

namespace App\Http\Controllers\Payment;

use App\Enums\Payment\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StoreFileCostRequest;
use App\Models\Currency;
use App\Models\File;
use App\Models\FileCost;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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

        return view('files.costs.index', [
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

        // Calculate totals
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];
        $validated['converted_total'] = $validated['total_price'] * $validated['exchange_rate'];

        // Set additional required fields
        $validated = array_merge($validated, [
            'customer_id' => $file->customer_id,
            'base_currency' => config('app.currency', 'EUR'),
            'created_by' => Auth::user()->id,
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
    public function edit(File $file, FileCost $cost)
    {
        return view('your.view', [
            'file' => $file,
            'cost' => $cost,
            'fileItem' => $cost->fileItem,
            'currencies' => Currency::all(),
        ]);
    }

    public function update(StoreFileCostRequest $request, File $file, FileCost $cost)
    {
        $validated = $request->validated();

        // Calculate totals
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];
        $validated['converted_total'] = $validated['total_price'] * $validated['exchange_rate'];

        $cost->update($validated);

        return redirect()
            ->to("/files/{$file->id}/items")
            ->with('success', 'Cost updated successfully');
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

        return back()->with('success', 'Payment status updated');
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
