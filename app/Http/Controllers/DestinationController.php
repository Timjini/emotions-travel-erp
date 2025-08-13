<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDestinationRequest;
use App\Models\Currency;
use App\Models\Destination;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DestinationController extends Controller
{
    /**
     * Display a listing of destinations.
     */
    public function index(Request $request): View
    {
        $destinations = Destination::latest()->paginate(10);

        return view('destinations.index', [
            'destinations' => $destinations,
        ]);
    }

    /**
     * Show the form for creating a new destination.
     */
    public function create(): View
    {
        $currencies = Currency::where('is_active', true)
                          ->orderBy('name')
                          ->get();
         $destination = new Destination();

        return view('destinations.create', compact('currencies', 'destination'));
    }

    /**
     * Store a newly created destination.
     */
    public function store(StoreDestinationRequest $request): RedirectResponse
    {
        Destination::create($request->validated());

        return redirect()
            ->route('destinations.index')
            ->with('success', 'Destination created successfully.');
    }

    /**
     * Display the specified destination.
     */
    public function show(Destination $destination): View
    {
        return view('destinations.show', [
            'destination' => $destination,
        ]);
    }

    /**
     * Show the form for editing the specified destination.
     */
    public function edit(Destination $destination): View
    {
       $currencies = Currency::where('is_active', true)
                          ->orderBy('name')
                          ->get();

        return view('destinations.edit', compact('destination', 'currencies'));
    }

    /**
     * Update the specified destination.
     */
public function update(StoreDestinationRequest $request, Destination $destination): RedirectResponse
{
    try {
        $destination->update($request->validated());

        return redirect()->route('destinations.show', ['destination' => $destination->id])
            ->with('success', 'Destination updated successfully.');

    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', $e->getMessage());
    }
}



    /**
     * Remove the specified destination.
     */
    public function destroy(Destination $destination): RedirectResponse
    {
        $destination->delete();

        return redirect()->route('destinations.index')
            ->with('success', 'Destination deleted successfully.');
    }
}
