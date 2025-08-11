<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Customer;
use App\Models\Destination;
use App\Models\File;
use App\Models\FileItem;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display the files.
     */
    public function index(Request $request): View
    {
        $files = File::with(['customer', 'program', 'destination', 'currency'])
            ->latest()
            ->paginate(10);

        return view('files.index', [
            'files' => $files,
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
            'file'        => $file,
            'programs'     => Program::all(),
            'customers'    => Customer::all(),
            'currencies'   => Currency::all(),
            'destinations' => Destination::all(),
        ]);
    }

    /**
     * Update the specified file in storage.
     */
    public function update(Request $request, File $file): RedirectResponse
    {
        $validated = $request->validate([
            'reference' => 'required|string|max:255|unique:files,reference,'.$file->id,
            'number_of_people' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'program_id' => 'nullable|exists:programs,id',
            'destination_id' => 'nullable|exists:destinations,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'guide' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'status' => 'required|string|in:pending,confirmed,cancelled',  
        ]);

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
            'reference' => 'required|string|max:255|unique:files',
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
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'currency_id' => 'required|exists:currencies,id',
        ]);

        $item->update($validated);

        return response()->json($item->load('currency'));
    }
}