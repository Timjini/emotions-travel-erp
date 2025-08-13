<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Destination;
use App\Models\File;
use App\Models\FileItem;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FileController extends Controller
{
    /**
     * Display the files.
     */
    public function index(Request $request): View
    {
        // Get sorting parameters
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        // Base query with relationships and sums
        $query = File::with([
            'customer',
            'program',
            'destination',
            'currency',
            'items' => function ($query) {
                $query->selectRaw('file_id, SUM(total_price) as total_price')
                    ->groupBy('file_id');
            },
            'costs' => function ($query) {
                $query->selectRaw('file_id, SUM(total_price) as total_price')
                    ->groupBy('file_id');
            },
        ])
            ->withSum('items', 'total_price')
            ->withSum('costs', 'total_price');

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('destination', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Apply status filter
        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }

        // Apply date range filter
        if ($request->has('start_date')) {
            $query->where('start_date', '>=', $request->get('start_date'));
        }
        if ($request->has('end_date')) {
            $query->where('end_date', '<=', $request->get('end_date'));
        }

        // Apply program filter
        if ($request->has('program_id')) {
            $query->where('program_id', $request->get('program_id'));
        }

        // Apply sorting
        $query->orderBy($sortField, $sortDirection);

        // Get paginated results
        $files = $query->paginate(10)
            ->appends($request->query());

        // Calculate statistics
        $stats = [
            'total_bookings' => File::count(),
            'confirmed_bookings' => File::where('status', 'confirmed')->count(),
            'pending_bookings' => File::where('status', 'pending')->count(),
            'cancelled_bookings' => File::where('status', 'cancelled')->count(),
        ];

        // Calculate financial summaries across all files
        $allFiles = File::with(['items', 'costs'])->get();

        $totalBilled = $allFiles->sum(function ($file) {
            return $file->items->sum('total_price');
        });

        $totalCosts = $allFiles->sum(function ($file) {
            return $file->costs->sum('total_price');
        });

        $profit = $totalBilled - $totalCosts;
        $profitMargin = $totalBilled > 0 ? ($profit / $totalBilled) * 100 : 0;

        // Calculate costs by service type (simplified example)
        $costsByServiceType = [
            'Accommodation' => $allFiles->sum(function ($file) {
                return $file->costs->where('service_type', 'accommodation')->sum('total_price');
            }),
            'Transport' => $allFiles->sum(function ($file) {
                return $file->costs->where('service_type', 'transport')->sum('total_price');
            }),
            'Activities' => $allFiles->sum(function ($file) {
                return $file->costs->where('service_type', 'activities')->sum('total_price');
            }),
            'Meals' => $allFiles->sum(function ($file) {
                return $file->costs->where('service_type', 'meals')->sum('total_price');
            }),
        ];

        // Payment status summary (example - adjust based on your actual data structure)
        $paymentStatusSummary = [
            'Paid' => $allFiles->where('payment_status', 'paid')->count(),
            'Partial' => $allFiles->where('payment_status', 'partial')->count(),
            'Pending' => $allFiles->where('payment_status', 'pending')->count(),
            'Overdue' => $allFiles->where('payment_status', 'overdue')->count(),
        ];

        // Prepare financial data for the view
        $financials = [
            'total_billed' => $totalBilled,
            'total_costs' => $totalCosts,
            'profit' => $profit,
            'profit_margin' => $profitMargin,
            'costs_by_service_type' => $costsByServiceType,
            'payment_status_summary' => $paymentStatusSummary,
        ];

        // Get all programs for filter dropdown
        $programs = Program::orderBy('name')->get();

        return view('files.index', [
            'files' => $files,
            'stats' => $stats,
            'financials' => $financials,
            'programs' => $programs,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }

    /**
     * Display the specified file.
     */
    public function show(File $file): View
    {
        return view('files.show', [
            'file' => $file->load(['customer', 'program', 'destination', 'currency']),
        ]);
    }

    /**
     * Show the form for editing the specified file.
     */
    public function edit(File $file): View
    {
        // $file->load(['programs', 'customer', 'currency', 'destination']);

        return view('files.edit', [
            'file' => $file,
            'programs' => Program::all(),
            'customers' => Customer::all(),
            'currencies' => Currency::all(),
            'destinations' => Destination::all(),
        ]);
    }

    /**
     * Update the specified file in storage.
     */
   public function update(StoreFileRequest $request, File $file)
{
    $validated = $request->validated();
    $file->update($validated);

    return redirect()->route('files.show', $file)
                     ->with('success', 'File updated successfully.');
}

    /**
     * Show the form for creating a new file.
     */
    public function create(): View
    {
        return view('files.create', [
            'customers' => Customer::all(),
            'programs' => Program::all(),
            'destinations' => Destination::all(),
            'currencies' => Currency::all(),
        ]);
    }

    /**
     * Store a newly created file in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'number_of_people' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'program_id' => 'nullable|exists:programs,id',
            'destination_id' => 'nullable|exists:destinations,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'guide' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        $file = File::create($validated);

        return redirect()->route('files.show', $file)
            ->with('success', 'File created successfully.');
    }

    /**
     * Remove the specified file from storage.
     */
    public function destroy(File $file): RedirectResponse
    {
        $file->delete();

        return redirect()->route('files.index')
            ->with('success', 'File deleted successfully.');
    }

    // file items

    /**
     * Show the form for adding items to a file
     */
    public function showAddItems(File $file): View
    {
        return view('files.items.create', [
            'file' => $file->load(['items.currency']),
            'currencies' => Currency::all(),
        ]);
    }

    /**
     * Store a new item for the file
     */
    public function storeItem(Request $request, File $file): RedirectResponse
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'external_ref' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'currency_id' => 'nullable|exists:currencies,id',
        ]);

        $file->items()->create($validated);

        return redirect()->route('files.items.add', $file)
            ->with('success', 'Item added successfully.');
    }

    /**
     * Remove an item from the file
     */
    public function destroyItem(File $file, FileItem $item): RedirectResponse
    {
        $item->delete();

        return redirect()->route('files.items.add', $file)
            ->with('success', 'Item removed successfully.');
    }

    /**
     * Edit File Items
     */
    public function updateItem(File $file, FileItem $item, Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'external_ref' => 'nullable|string',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'currency_id' => 'required|exists:currencies,id',
        ]);

        $item->update($validated);

        return response()->json($item->load('currency'));
    }
}
