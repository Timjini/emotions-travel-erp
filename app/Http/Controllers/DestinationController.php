<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        return view('destinations.create');
    }

    /**
     * Store a newly created destination.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Destination::create($validated);

        session()->flash('success', 'Destination created successfully.');

        return redirect()->route('destinations.index')
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
        return view('destinations.edit', [
            'destination' => $destination,
        ]);
    }

    /**
     * Update the specified destination.
     */
    public function update(Request $request, Destination $destination): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $destination->update($validated);

        return redirect()->route('destinations.show', $destination)
            ->with('success', 'Destination updated successfully.');
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