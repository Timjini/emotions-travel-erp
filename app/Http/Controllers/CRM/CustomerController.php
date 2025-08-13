<?php

namespace App\Http\Controllers\CRM;

use App\Enums\CustomerCategory;
use App\Enums\CustomerStatus;
use App\Enums\CustomerType;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $query = Customer::query();

        $customers = $query->latest()->paginate(10)->withQueryString();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('email', 'like', '%'.$request->search.'%')
                    ->orWhere('invoicing_entity', 'like', '%'.$request->search.'%')
                    ->orWhere('phone_1', 'like', '%'.$request->search.'%');
            });
        }

        $customers = $query->latest()->paginate(10)->withQueryString();

        return view('crm.customers.index', compact('customers'));
    }

    public function create(): View
    {
        return view('crm.customers.create');
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
            'type' => 'required|in:'.implode(',', CustomerType::values()),
            'category' => 'nullable|in:'.implode(',', CustomerCategory::values()),
            'iban' => 'nullable|string|max:34',
            'swift_code' => 'nullable|string|max:11',
            'status' => 'required|in:'.implode(',', CustomerStatus::values()),
            'preferred_language' => 'nullable|string|max:5',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');

        return back()->with('error', 'Something went wrong.');
    }

    public function show(Customer $customer): View
    {
        return view('crm.customers.show', compact('customer'));
    }

    public function edit(Customer $customer): View
    {
        return view('crm.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'invoicing_entity' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'post_code' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'country' => 'required|string|max:20',
            'email' => 'nullable|email|max:255|unique:customers,email,'.$customer->id,
            'contact_person' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'vat_number' => 'nullable|string|max:50',
            'phone_1' => 'nullable|string|max:20',
            'phone_2' => 'nullable|string|max:20',
            'type' => 'required|in:'.implode(',', CustomerType::values()),
            'category' => 'nullable|in:'.implode(',', CustomerCategory::values()),
            'iban' => 'nullable|string|max:34',
            'swift_code' => 'nullable|string|max:11',
            'status' => 'required|in:'.implode(',', CustomerStatus::values()),
            'preferred_language' => 'nullable|string|max:5',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.show', $customer)
            ->with('success', __('Customer updated successfully.'));
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
