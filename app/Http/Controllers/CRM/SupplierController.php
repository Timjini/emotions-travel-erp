<?php

namespace App\Http\Controllers\CRM;

use App\Enums\Supplier\SupplierCategory;
use App\Enums\Supplier\SupplierStatus;
use App\Enums\Supplier\SupplierType;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(Request $request): View
    {
        $query = Supplier::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('email', 'like', '%'.$request->search.'%')
                    ->orWhere('invoicing_entity', 'like', '%'.$request->search.'%')
                    ->orWhere('phone_1', 'like', '%'.$request->search.'%');
            });
        }

        $suppliers = $query->latest()->paginate(10)->withQueryString();

        return view('crm.suppliers.index', compact('suppliers'));
    }

    public function create(): View
    {
        return view('crm.suppliers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'invoicing_entity' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'post_code' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'country' => 'required|string|max:20',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'contact_person' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'vat_number' => 'nullable|string|max:50',
            'phone_1' => 'nullable|string|max:20',
            'phone_2' => 'nullable|string|max:20',
            'type' => 'required|in:'.implode(',', SupplierType::values()),
            'category' => 'nullable|in:'.implode(',', SupplierCategory::values()),
            'iban' => 'nullable|string|max:34',
            'swift_code' => 'nullable|string|max:11',
            'status' => 'required|in:'.implode(',', SupplierStatus::values()),
            'preferred_language' => 'nullable|string|max:5',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();

        Supplier::create($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier created successfully.');

        return back()->with('error', 'Something went wrong.');
    }

    public function show(Supplier $supplier): View
    {
        return view('crm.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier): View
    {
        return view('crm.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'invoicing_entity' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'post_code' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'country' => 'required|string|max:20',
            'email' => 'nullable|email|max:255|unique:customers,email,'.$supplier->id,
            'contact_person' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'vat_number' => 'nullable|string|max:50',
            'phone_1' => 'nullable|string|max:20',
            'phone_2' => 'nullable|string|max:20',
            'type' => 'required|in:'.implode(',', SupplierType::values()),
            'category' => 'nullable|in:'.implode(',', SupplierCategory::values()),
            'iban' => 'nullable|string|max:34',
            'swift_code' => 'nullable|string|max:11',
            'status' => 'required|in:'.implode(',', SupplierStatus::values()),
            'preferred_language' => 'nullable|string|max:5',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.show', $supplier)
            ->with('success', __('Supplier updated successfully.'));
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }
}
