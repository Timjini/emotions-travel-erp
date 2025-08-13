<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CurrencyController extends Controller
{
    public function index(): View
    {
        $currencies = Currency::latest()->paginate(10);

        return view('currencies.index', compact('currencies'));
    }

    public function create(): View
    {
        return view('currencies.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|size:3|unique:currencies',
            'name' => 'required|string|max:255',
            'symbol' => 'nullable|string|max:5',
            'is_active' => 'boolean',
        ]);

        Currency::create($validated);

        return redirect()->route('currencies.index')
            ->with('success', 'Currency created successfully.');
    }

    public function show(Currency $currency): View
    {
        return view('currencies.show', compact('currency'));
    }

    public function edit(Currency $currency): View
    {
        return view('currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|size:3|unique:currencies,code,'.$currency->id,
            'name' => 'required|string|max:255',
            'symbol' => 'nullable|string|max:5',
            'is_active' => 'boolean',
        ]);

        $currency->update($validated);

        return redirect()->route('currencies.show', $currency)
            ->with('success', 'Currency updated successfully.');
    }

    public function destroy(Currency $currency): RedirectResponse
    {
        $currency->delete();

        return redirect()->route('currencies.index')
            ->with('success', 'Currency deleted successfully.');
    }
}
